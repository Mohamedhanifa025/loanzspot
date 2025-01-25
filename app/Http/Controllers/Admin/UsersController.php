<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(\Gate::allows('user_access'), 403);

        $users = new User;

        if($request->has('term') && $request->term != '') {
            $users = $users->where('name', 'LIKE', "%$request->term%")
                ->orWhere('email', 'LIKE', "%$request->term%")
                ->orWhere('id', str_replace('emp', '',strtolower($request->term)))
                ->orWhere('id', str_replace('emp0', '',strtolower($request->term)));
                //->orWhere('mobile_number', 'LIKE', "%$request->term%");
        }

        if($request->has('status') && $request->status != '') {
            $users = $users->where('status', $request->status);
        }

        $users = $users->orderBy('id', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        abort_unless(\Gate::allows('user_create'), 403);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            //'mobile_number' => 'required|integer|digits:10',
        ]);
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');
        $authUser = false;
        if(($user->id == Auth::user()->id)) {
            $authUser = true;
        }
        return view(($authUser)?'admin.users.edit_profile':'admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        abort_unless(\Gate::allows('user_edit'), 403);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            //'mobile_number' => 'required|integer|digits:10',
        ]);
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index')->with('success', "Employee info successfully!");
    }

    public function updateProfile(Request $request, $id)
    {
        abort_unless(\Gate::allows('user_edit'), 403);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            //'mobile_number' => 'required|integer|digits:10',
        ]);
        $user = User::find($id);
        $user->update($request->all());

        return redirect()->back()->with('success', "Profile updated successfully!");
    }

    public function show(User $user)
    {
        abort_unless(\Gate::allows('user_show'), 403);

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_unless(\Gate::allows('user_delete'), 403);

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }

    public function updatePassword(Request $request)
    {
        abort_unless(\Gate::allows('user_edit'), 403);

        $this->validate($request, [

            'old_password' => 'required',
            'password' => 'required',
            'retype_password' => 'required',
        ]);

        $user = User::find(auth()->user()->id);

        $hashedPassword = $user->password;

        if (\Hash::check($request->old_password , $hashedPassword )) {

            if($request->password != $request->retype_password) {
                return redirect()->back()->with('error','Your password confirmation does not match!');
            }
            if (!\Hash::check($request->password , $hashedPassword)) {

                $user->password = bcrypt($request->password);
                $user->save();

                return redirect()->back()->with('success','Password updated successfully');
            } else {
                return redirect()->back()->with('error','New password can not be the old password!');
            }
        } else {
            return redirect()->back()->with('error','Old password doesnt matched!');
        }
    }

    public function changePassword(User $user)
    {
        abort_unless(\Gate::allows('user_show'), 403);

        return view('admin.users.change_password');
    }
}
