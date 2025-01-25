<?php

namespace App\Http\Controllers\Admin;

use App\ApplyLoan;
use App\Channel;
use App\Customer;
use App\Http\Controllers\Controller;
use App\LeadMaker;
use App\Mail\LeadMakerNotification;
use App\ReferralBonus;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class LeadMakersController extends Controller
{

    protected $treeMapLoop = [];

    protected $treeMap = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leadMakers = LeadMaker::orderBy('id', 'desc')->get();
        if (count(auth()->user()->channel)) {
            $channels = auth()->user()->channel()->pluck('id')->toArray();
            $leadMakers= LeadMaker::whereIn('channel_id', $channels)->orderBy('id', 'desc')->get();
        }
        return view('admin.lead_makers.index', compact('leadMakers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $count = LeadMaker::count();
        $channels = Channel::get();
        if (count(auth()->user()->channel)) {
            $channels = auth()->user()->channel()->get();
        }
        return view('admin.lead_makers.create', compact('count','channels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all(),$request->only('name','email', 'password'));
        $leadUserLoan = ApplyLoan::where('email', $request->email)->orderBy('created_at', 'asc')->first();
        $user = \App\User::where('email', $request->email)->first();
        $request->merge(['referred_by' => $leadUserLoan->lead_reference_id ?? null]);
        if(is_null($user)) {
            $user = \App\User::create($request->only('name', 'email', 'password'));
        }
        $leadMakerRole = Role::where('title', 'Lead Maker')->first();
        $user->roles()->attach($leadMakerRole);
        $request->merge(['user_id' => $user->id]);
        //dd($request->except('_token', 'password'));
        $channel = LeadMaker::create($request->except('_token', 'email','password'));

        if($request->has('email_notify')) {
            Mail::to($user->email)->send(new LeadMakerNotification($user));
        }

        return redirect('admin/lead-makers')->with('success', 'Lead Makers is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LeadMaker  $leadMaker
     * @return \Illuminate\Http\Response
     */
    public function show(LeadMaker $leadMaker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LeadMaker  $leadMaker
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadMaker $leadMaker)
    {
        $count = LeadMaker::count();
        $channels = Channel::where('id', $leadMaker->channel_id)->get();
        return view('admin.lead_makers.edit', compact('count','leadMaker', 'channels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeadMaker  $leadMaker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadMaker $leadMaker)
    {
        $userData = $request;
        $leadMaker->user()->update($userData ->only('name', 'email'));
        if(!is_null($request->password)) {
            $leadMaker->user()->update($userData ->only('password'));
        }
        $leadMaker->update($request->except('_token', 'email','password'));
        return redirect('admin/lead-makers')->with('success', 'Lead Maker is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeadMaker  $leadMaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadMaker $leadMaker)
    {
        $leadMaker->delete();
        return redirect('admin/lead-makers')->with('success', 'Lead Maker is deleted successfully!');
    }

    public function convert($id)
    {
        $customer = Customer::find($id);
        $count = LeadMaker::count();
        $leadMakerLink = 'LS_LM_' . ((strlen($count) > 1) ? $count + 1 : '0' . ($count + 1));
        $request = new Request();
        $request->merge(['email' => $customer->email,
            'name' => $customer->name,
            'password' => $customer->password,
            'mobile_number' => $customer->mobile_number,
            'address' => $customer->address,
            'city' => $customer->city,
            'pin_code' => $customer->pincode,
            'lead_maker_id' => $leadMakerLink,
            'lead_generation_link' => route('apply.loan.view', ['utm_source' => $leadMakerLink]),
            'joining_date' => date('Y-m-d'),
            'status' => 1,
            'email_notify' => true
        ]);
        return LeadMakersController::store($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeadMaker  $leadMaker
     * @return \Illuminate\Http\Response
     */
    public function treeView($id)
    {
        $leadMaker = LeadMaker::find($id);
        $treeMap = $this->buildTreeMap($leadMaker);
        $totalEarned = ReferralBonus::where('referrer_id', $leadMaker->user->id)->sum('bonus_amount');
        $currentRewards = $totalEarned;
        //$treeMap = $this->treeMapLoop;
        //dd($treeMap);
        return view('admin.lead_makers.tree_view', compact('leadMaker', 'treeMap', 'currentRewards', 'totalEarned'));
    }

    private function buildTreeMap(LeadMaker $leadMaker)
    {
        $treeMap = [];

        $this->recursiveTreeMap($leadMaker, $treeMap);

        return $treeMap;
    }

    private function recursiveTreeMap(LeadMaker $leadMaker, array &$treeMap)
    {
        $loans = ApplyLoan::where('lead_reference_id', $leadMaker->id)->get();

        foreach ($loans as $key => $loan) {
            $childLeadMaker = LeadMaker::whereHas('user', function ($q) use ($loan) {
                $q->where('email', $loan->email);
            })->first();
            $treeMap[$leadMaker->lead_maker_id][$key]['id'] = $loan->id;
            $treeMap[$leadMaker->lead_maker_id][$key]['referrer_id'] = $loan->referrer->id;
            $treeMap[$leadMaker->lead_maker_id][$key]['referrer_lead_maker_id'] = $loan->referrer->lead_maker_id;
            $treeMap[$leadMaker->lead_maker_id][$key]['name'] = $loan->name;
            $treeMap[$leadMaker->lead_maker_id][$key]['email'] = $loan->email;
            $treeMap[$leadMaker->lead_maker_id][$key]['status'] = $loan->status;
            $treeMap[$leadMaker->lead_maker_id][$key]['lead_maker_id'] = $childLeadMaker ? $childLeadMaker->lead_maker_id : '';

            $childLeadMaker = LeadMaker::whereHas('user', function ($q) use ($loan) {
                $q->where('email', $loan->email);
            })->first();

            if ($childLeadMaker) {
                $treeMap[$leadMaker->lead_maker_id][$key]['data'] = $this->recursiveTreeMap($childLeadMaker, $treeMap[$leadMaker->lead_maker_id]);
            }
        }
        return $treeMap;
    }

    public function buildTree($leadMakerId, $key = null)
    {
        // If no key is provided, use "LS_LM_<leadMakerId>"
        $key = $key ?? "LS_LM_{$leadMakerId}";

        // Initialize the tree map for this key
        $this->treeMap[$key] = [];

        // Fetch the loans associated with this lead maker
        $loans = ApplyLoan::where('lead_reference_id', $leadMakerId)->get();

        foreach ($loans as $loan) {
            // Add the loan user's details under the current lead maker
            $this->treeMap[$key][] = [
                'name' => $loan->name,
                'email' => $loan->email,
                'status' => $loan->status,
            ];

            // Check if the loan user is also a lead maker
            $loanLeadMaker = LeadMaker::whereHas('user', function ($query) use ($loan) {
                $query->where('email', $loan->email);
            })->first();

            if ($loanLeadMaker) {
                // Recursively build the tree for this lead maker
                $this->buildTree($loanLeadMaker->id, "LS_LM_{$loanLeadMaker->id}");
            }
        }

        return $this->treeMap;
    }


    public function treeLoop($leadMakerId, $lid)
    {
        // Get all loans associated with the current lead maker
        $treeLoans = ApplyLoan::where('lead_reference_id', $leadMakerId)->get();

        // Ensure the current key is initialized in the tree map
        if (!isset($this->treeMapLoop[$lid])) {
            $this->treeMapLoop[$lid] = [];
        }

        foreach ($treeLoans as $loan) {
            // Find if the loan user is also a lead maker
            $leadMaker = LeadMaker::whereHas('user', function ($query) use ($loan) {
                $query->where('email', $loan->email);
            })->first();
            // Add loan user under the current key
            $this->treeMapLoop[$lid][] = $loan->name;

            if ($leadMaker) {
                // Generate the new key for the nested lead maker
                $newLid = $leadMaker->lead_maker_id;

                // Initialize the nested key under the current $lid if it doesn't exist
                if (!isset($this->treeMapLoop[$lid][$newLid])) {
                    $this->treeMapLoop[$lid][$newLid] = [];
                }

                // Recursively build the tree for the next lead maker
                $this->treeLoop($leadMaker->id, $newLid);
            }
        }
    }
    /*public function treeLoop($leadMakerId, $lid)
    {
        $treeLoans = ApplyLoan::where('lead_reference_id', $leadMakerId)->get();
        $tree = [];
        foreach ($treeLoans as $loans) {
            $leadMaker = LeadMaker::whereHas('user', function ($q) use ($loans) {
                $q->where('email', $loans->email);
            })->first();
            if (!is_null($leadMaker)) {
                $tree[$lid][] = $this->treeLoop($leadMaker->id, [$lid][$leadMaker->lead_maker_id]);
            } else {
                $tree[] = $loans->name;
            }
        }
        dd($tree);
        return $tree;
    }*/

    /*/*$referredUsers = User::where('referred_by', $userId)->get();
      if(count($referredUsers) > 0) {
            foreach ($referredUsers as $ruser) {
                $this->treeMapLoop[$loop][] = $ruser->leadMaker ? $ruser->leadMaker->id : ($ruser->id.'-'.$ruser->email);
                //$loop = $ruser->leadMaker ? $ruser->leadMaker->lead_maker_id : ($ruser->id.'-'.$ruser->email);
                //$this->treeLoop($ruser->id, $loop);
            }
        }*/
}
