<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ContactImport;
use App\User;
use Illuminate\Http\Request;
use App\Contacts;
use Excel;

class ContactsController extends Controller
{

    public function index(Request $request)
    {
        $contacts = new Contacts;

        if($request->has('term') && $request->term != '') {
            $contacts = $contacts->where(function ($q) use($request) {
                $q->where('name', 'LIKE', "%$request->term%")
                    ->orWhere('mobile_number', 'LIKE', "%$request->term%");
            });
        }
        if($request->has('employee_id') && $request->employee_id != '') {
            $contacts = $contacts->where('user_id', $request->employee_id);
        }
        if(in_array(2, auth()->user()->roles->pluck('id')->toArray())) {
            $contacts = $contacts->where('user_id', auth()->user()->id);
        }

        $contacts = $contacts->orderBy('id', 'desc')->get();

        $users = User::all();

      return view('admin.contacts.index' , compact('contacts', 'users'));
    }
    public function create()
    {
        abort_unless(\Gate::allows('contact_create'), 403);

        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile_number' => 'required|integer|digits:10',
           ]);
        $request->merge(['user_id' => auth()->user()->id]);
        $contact = Contacts::create($request->all());

        return redirect()->route('admin.contacts.index');
    }

    public function edit(Contacts $contact)
    {
        abort_unless(\Gate::allows('contact_edit'), 403);

        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contacts $contact)
    {
        abort_unless(\Gate::allows('contact_edit'), 403);
        $request->validate([
            'name' => 'required',
            'mobile_number' => 'required|integer|digits:10',
        ]);
        $contact->update($request->all());

        return redirect()->route('admin.contacts.index');
    }

    public function show(Contacts $contact)
    {
        abort_unless(\Gate::allows('contact_show'), 403);

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contacts $contact)
    {
        abort_unless(\Gate::allows('contact_delete'), 403);

        $contact->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Contacts::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import()
    {
        Excel::import(new ContactImport(),request()->file('file'));

        return back()->with('success', 'Contacts imported successfully!');
    }
}
