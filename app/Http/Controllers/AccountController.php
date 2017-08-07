<?php

namespace App\Http\Controllers;

use App\Domain\Crews\Crew;
use App\Domain\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(Request $request) {

        if(!Auth::user()->isGlobalAdmin()) {
            // Only Global Admins can access this
            return redirect()->back()->withErrors("Unauthorized");
        }

        // Authorization complete - continue...
        $users = User::orderBy('firstname', 'asc')
            ->orderBy('lastname','asc')
            ->get();
        $crews = Crew::orderBy('name')->get();

        $request->session()->flash('active_menubutton','accounts'); // Tell the menubar which button to highlight
        return view('auth.index', ['users' => $users,
            'crews' => $crews ]);

    } // End index()


    public function edit($id) {

        $target_user = User::findOrFail($id);

        // Make sure this user is authorized...
        if(Auth::user()->cannot('act-as-admin-for-crew', $target_user->crew_id)) {
            // The current user does not have permission to perform admin functions for this crew
            return redirect()->back()->withErrors("You're not authorized to access that crew!");
        }

        // Authorization complete - continue...
        return 'Edit account: '.$id;
    } // End edit()

    public function update($id) {
        return $this->response()->error('Not implemented', 500);
    }

    public function destroy($id) {
        // Delete the User with ID $id
        $user_to_destroy = User::findOrFail($id);

        if(Auth::user()->cannot('destroy_user', $user_to_destroy)) {
            // The current user does not have permission to destroy the requested user
            return redirect()->back()->withErrors("You're not authorized to destroy that Account!");
        }

        // Authorization complete - continue...
        $user_to_destroy->delete();

        $alert_message = array('message' => "That account was deleted.", 'type' => "success");
        if(Auth::user()->isGlobalAdmin()) {
            return redirect()->route('users_index')->with('alert', $alert_message);
        }
        else {
            return redirect()->route('users_for_crew',Auth::user()->crew_id)->with('alert', $alert_message);
        }

    } // End destroy()
}
