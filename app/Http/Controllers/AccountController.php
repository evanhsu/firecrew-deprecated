<?php

namespace App\Http\Controllers;

use App\Domain\Crews\Crew;
use App\Domain\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
    }

    public function index(Request $request) {

        if(!Auth::user()->isGlobalAdmin()) {
            // Only Global Admins can access this
            return redirect()->back()->withErrors("Unauthorized");
        }

        // Authorization complete - continue...
        $users = User::orderBy('name', 'asc')
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

        if(Auth::user()->cannot('destroyUser', $user_to_destroy)) {
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



    /**
     * Show the "Create New User" form.
     *
     * @param Request $request
     * @param $crewId
     * @return \Illuminate\Http\Response
     */
    public function getRegister(Request $request, $crewId)
    {
        $crew = Crew::findOrFail($crewId);
        if(Auth::user()->cannot('act-as-admin-for-crew', $crew)) {
            // The current user does not have permission to register a user for the specified crew
            return redirect()->back()->withErrors("You're not authorized to register users for that crew!");
        }

        // Authorization complete - continue...
        $request->session()->flash('active_menubutton','accounts'); // Tell the menubar which button to highlight
        return view('auth.new_user')->with("crewId",$crewId);
    }

    /**
     * Handle a New User request for the application (this is not a user signing themselves up,
     * it's a crew admin creating a user for their crew).
     * This Action accepts input from the "New User" form and passes it
     * through the Validator.
     * If validation passes, THEN the form input is passed to the CREATE action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegisterUserForCrew(Request $request)
    {
        // Make sure this user is authorized...
        if(Auth::user()->cannot('act-as-admin-for-crew', $request->get('crew_id'))) {
            // The current user does not have permission to create a user account for this crew
            return redirect()->back()->withErrors("You're not authorized to register users for that crew!");
        }
        // Authorization complete - continue...
        // Run the form input through the validator
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            /* $this->throwValidationException(
                 $request, $validator
             );*/
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if(!$this->create($request->all())) {
            return redirect()->back()->withErrors("The user account couldn't be created.");
        };


        if(Auth::user()->isGlobalAdmin()) {
            return redirect()->route('users_index');
        } else {
            return redirect()->route('users_for_crew', ["crewId" => Auth::user()->crew_id]);
        }
    }

    /**
     * Create a new user instance AFTER a valid registration.
     * This action is protected and is called from the 'postRegister' action.
     *
     * @param  array  $data
     * @return User|null
     */
    protected function create(array $data)
    {
        // TODO: Change this to generate a random password and send it to the user in an email.
        // $password = $this->randomPassword();

        $user = User::create([
            'name' => $data['firstname']." ".$data['lastname'],
            'email'     => $data['email'],
            'password' => Hash::make($data['password']),
            'crew_id'   => $data['crew_id'],
        ]);

        if(!$user) {
            return null;
        }

        // Send WELCOME email to new user, including the randomly-generated password
        // sendEmail($new_user, $new_user_data['password']);

        return $user;

    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
