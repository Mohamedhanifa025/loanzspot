<?php

namespace App\Http\Controllers\Admin;

use App\ApplyLoan;
use App\Contacts;
use App\Http\Controllers\Controller;
use App\LeadMaker;
use App\Notification;
use App\PaymentTransfer;
use App\Referral;
use App\ReferralBonus;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoansController extends Controller
{
  public function index(Request $request)
  {
      $leadMakers = null;
      $loans = new ApplyLoan;
      if ($request->has('term') && $request->term != '') {
          $loans = $loans->where(function ($q) use($request) {
              $l = $q->where('name', 'LIKE', "%$request->term%")
                  ->orWhere('email', 'LIKE', "%$request->term%")
                  ->orWhere('mobile_number', 'LIKE', "%$request->term%");
              $types = array_flip(config('constant.loan_types'));
              if(array_key_exists($request->term, $types)) {
                  $l = $l->
                  orWhere('type', $types);
              }
          });
      }
      if ($request->has('status') && $request->status != '') {
          $loans = $loans->where('status', decrypt($request->status));
      }
      if (count(auth()->user()->channel)) {
          $channels = auth()->user()->channel()->pluck('id')->toArray();
          $leadMakers= LeadMaker::whereIn('channel_id', $channels)->get();
      }
      if (count(auth()->user()->channel)) {
          $channels = auth()->user()->channel()->pluck('id')->toArray();
          $leadMakers= LeadMaker::whereIn('channel_id', $channels)->pluck('id')->toArray();
      }
      if (auth()->user()->leadMaker) {
          $leadMakers = LeadMaker::whereIn('id', auth()->user()->leadMaker)->pluck('id')->toArray();
      }
      if(!is_null($leadMakers)) {
          $loans = $loans->whereIn('lead_reference_id', $leadMakers);
      }
      $loans = $loans->orderBy('id', 'desc')->get();

    return view('admin.loans.index' , compact('loans'));
  }
  public function create()
  {
      abort_unless(\Gate::allows('loan_create'), 403);

      return view('admin.loans.create');
  }

  public function store(Request $request)
  {
      $request->validate([
          'type' => 'required',
          'email' => 'required',
          'name' => 'required',
          'mobile_number' => 'required|digits:10',
          'company_name' => 'required_if:type,pl',
          'salary' => 'required_if:type,pl',
          'company_type' => 'required_if:type,bl,hl,cl,lap',
          'business_type' => 'required_if:type,bl,hl,cl,lap',
          'income_type' => 'required_if:type,bl,hl,cl,lap',
          'employee_type' => 'required_if:type,dl',
          'message' => 'required',
          'location' => 'required',
      ]);
      $leadMaker = LeadMaker::where('lead_maker_id', $request->lead_reference_id)->first();
      $request->merge([
          'lead_reference_id' => $leadMaker ? $leadMaker->id : null,
      ]);

      $loan = ApplyLoan::create($request->except('_token'));

      return redirect()->route('admin.loans.index')->with('success', 'Loan Application Submitted Successfully!');
  }

  public function edit(ApplyLoan $loan)
  {
      abort_unless(\Gate::allows('loan_edit'), 403);

      return view('admin.loans.edit', compact('loan'));
  }

  public function update(Request $request, ApplyLoan $loan)
  {
      abort_unless(\Gate::allows('loan_edit'), 403);
      $request->validate([
          'type' => 'required',
          'email' => 'required',
          'name' => 'required',
          'mobile_number' => 'required|digits:10',
          'company_name' => 'required_if:type,pl',
          'salary' => 'required_if:type,pl',
          'company_type' => 'required_if:type,bl,hl,cl,lap',
          'business_type' => 'required_if:type,bl,hl,cl,lap',
          'income_type' => 'required_if:type,bl,hl,cl,lap',
          'employee_type' => 'required_if:type,dl',
          'message' => 'required',
          'location' => 'required',
      ]);
      $loan->update($request->all());
      if($loan->status == 1) {
          $this->calculateReferralBonus($loan->id);
      }

      /*if(is_null($loan->customer_id)) {
          $getCustomer = User::where('mobile_number', $loan->mobile_number)->first();
          if(is_null($getCustomer)) {
              return redirect()->route('admin.loans.index')->with('error', 'Create a customer with loan\'s mobile number first!');
          } else {
              $loan->update(['customer_id' => $getCustomer->id]);
          }
      }
      $getContact = Contacts::where('mobile_number', $request->mobile_number)->first();
      $msg = 'Loan application updated successfully!';
      if(!is_null($getContact) && !is_null($getContact->customer_id)) {
          $ref['apply_loan_id'] = $loan->id;
          $ref['customer_id'] = $loan->customer_id;
          $ref['referred_id'] = $getContact->customer_id;
          $ref['points'] = env('REFERRAL_POINTS', 10);
          $ref['status'] = $loan->status;
          Referral::updateOrCreate([
              'customer_id' => $ref['customer_id'],
              'referred_id' => $ref['referred_id'],
              'apply_loan_id' => $ref['apply_loan_id']
          ], $ref);
      } else {
          $msg .= " And, No Referral customer found for loan mobile number $loan->mobile_number!";
      }*/
      $msg = 'Loan application updated successfully!';
      return redirect()->route('admin.loans.index')->with('success', $msg);
  }

  public function show(ApplyLoan $loan)
  {
      abort_unless(\Gate::allows('loan_show'), 403);

      return view('admin.loans.show', compact('loan'));
  }

  public function destroy(ApplyLoan $loan)
  {
      abort_unless(\Gate::allows('loan_delete'), 403);

      $loan->delete();

      return back();
  }

  public function massDestroy(Request $request)
  {
      ApplyLoan::whereIn('id', request('ids'))->delete();

      return response(null, 204);
  }

    public function calculateReferralBonus($loanId)
    {
        $loan = ApplyLoan::with('referrer')->find($loanId);

        if (!$loan) {
            throw new Exception("Loan not found");
        }

        $referrer = $loan->referrer ? $loan->referrer->user->id : null;
        $level = 1;
        $settings = Setting::where('type', 'rewards')->pluck('value', 'key')->toArray();
        $bonusAmounts = [1 => $settings['primary_reward_value'], 2 => $settings['secondary_reward_value'], 3 => $settings['territory_reward_value']];
        if(!is_null($referrer)) {
            while ($referrer && $level <= 3) {
                ReferralBonus::create([
                    'loan_id' => $loan->id,
                    'referrer_id' => $referrer,
                    'level' => $level,
                    'bonus_amount' => $bonusAmounts[$level],
                ]);
                $this->checkReferralBonusAndNotify($referrer);

                $referrer = User::find($referrer)->referred_by;
                $level++;
            }
        }
    }

    public function checkReferralBonusAndNotify($userId)
    {
        try {
            // Fetch the referral data in a single query
            $referral = ReferralBonus::where('referrer_id', $userId)->with('referrer.leadMaker')->get();

            if ($referral->isEmpty()) {
                Log::info("No referral bonuses found for user ID: $userId");
                return;
            }

            $user = $referral->first()->referrer;
            $leadMakerId = $user->leadMaker->id ?? null;

            // Calculate sums
            $totalBonus = $referral->sum('bonus_amount');
            $totalPayments = $leadMakerId ? PaymentTransfer::where('lead_maker_id', $leadMakerId)->sum('amount') : 0;
            $balanceSum = $totalPayments - $totalBonus;

            // Notify if the balance meets the threshold
            if ($balanceSum >= 15000) {
                Notification::create([
                    'user_id' => $userId,
                    'title' => "Bonus Rs. 15000 is accumulated for user {$user->name}",
                    'description' => "Bonus Rs. 15000 is accumulated for user {$user->name}",
                ]);
            }
        } catch (\Exception $e) {
            // Detailed error logging
            Log::error("Exception in checkReferralBonusAndNotify: {$e->getMessage()}", [
                'userId' => $userId,
                'stackTrace' => $e->getTraceAsString(),
            ]);
        }
    }
}
