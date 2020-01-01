<?php

namespace App\Http\Controllers;

use App\User;
use Lubus\Constants\Status;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::excludeArchive()->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'unique:users,email',
            'photo' => 'image|mimes:jpg,jpeg,png',
        ]);

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'photo' => '',
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ];
        $user = new User($user);
        $user->save();

        if ($user->id) {
            if ($request->hasFile('photo')) {
                $user->photo = \constFilePrefix::StaffPhoto.$user->id.'.'. $request->photo->getClientOriginalExtension();
                $user->save();
                \Utilities::uploadFile($request, \constFilePrefix::StaffPhoto, $user->id, 'photo', \constPaths::StaffPhoto);
            }

            flash()->success('User was successfully registered');
            return redirect('users');
        } else {
            flash()->error('Error while user registration');
            return redirect('users');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'photo' => 'image|mimes:jpg,jpeg,png',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != '') {
            $user->password = bcrypt($request->password);
        }
        $user->status = $request->status;
        $user->update();
        if ($request->hasFile('photo')) {
            $user->photo = \constFilePrefix::staffPhoto.$user->id.'.'. $request->photo->getClientOriginalExtension();
            $user->save();

            \Utilities::uploadFile($request, \constFilePrefix::staffPhoto, $user->id, 'photo', \constPaths::staffPhoto);
        }

        flash()->success('User details was successfully updated');
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function archive(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->status = \constStatus::Archive;
        $user->save();

        flash()->error('User was successfully deleted');
        return redirect('users');
    }
}
