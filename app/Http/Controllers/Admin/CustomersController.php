<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{

    public function index(Request $request)
    {
        $customers = new Customer;

        if($request->has('term') && $request->term != '') {
            $customers = $customers->where('name', 'LIKE', "%$request->term%")
            ->orWhere('email', 'LIKE', "%$request->term%")
            ->orWhere('mobile_number', 'LIKE', "%$request->term%");
        }

        if($request->has('status') && $request->status != '') {
            $customers = $customers->where('status', $request->status);
        }

        $customers = $customers->orderBy('id', 'desc')->get();

      return view('admin.customers.index' , compact('customers'));
    }
    public function create()
    {
        abort_unless(\Gate::allows('customer_create'), 403);
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('admin.customers.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'mobile_number' => 'required|integer|digits:10',
           'email' => 'required',
           'password' => 'required',
           'address' => 'required',
           'city' => 'required',
           'pincode' => 'required|integer|digits:6',
        ]);
        $request->merge(['password' => bcrypt($request->password)]);
        $customer = Customer::create($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully!');
    }

    public function edit(Customer $customer)
    {
        abort_unless(\Gate::allows('customer_edit'), 403);
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('admin.customers.edit', compact('customer', 'customers'));
    }

    public function update(Request $request, Customer $customer)
    {
        abort_unless(\Gate::allows('customer_edit'), 403);
        $request->validate([
            'name' => 'required',
            'mobile_number' => 'required|integer|digits:10',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required|integer|digits:6',
        ]);
        $data = $request->all();
        if($request->has('password') && $request->password != '' && !is_null($request->password)) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = $request->except(['password']);
        }
        $customer->update($data);

        return redirect()->route('admin.customers.index')->with('success', 'Customer update successfully!');
    }

    public function show(Customer $customer)
    {
        abort_unless(\Gate::allows('customer_show'), 403);

        return view('admin.customers.show', compact('customer'));
    }

    public function destroy(Customer $customer)
    {
        abort_unless(\Gate::allows('customer_delete'), 403);

        $customer->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
      Customer::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
