<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/';
    protected function authenticated(Request $request, $user)
    {
        return $this->redirectToLandingPage($user);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function redirectToLandingPage(User $user) {
        // Determine what page the current user should land on after a successful login.
        // Return a RedirectResponse to that page.
//        $user = Auth::user();
        // var_dump($user);

        if($user->isGlobalAdmin()) {
            // If this user is an Admin, land on the list of all Crews (Crews@getIndex)
            return redirect()->route('crews_index');
        }
        else {
            // If this user is NOT an Admin, decide which page to display:
            //   1. Look for the most recent Status that this user has submitted
            //   2. If found, go to the Status Update page for the Crew or Aircraft that this User last updated.
            //   3. If the Crew is statusable, go to the New Status form for the crew.
            //   4. If the Crew has aircrafts that are statusable, go to the New Status form for the Aircraft with highest alphabetical priority.
            //   5. If not found, or this User no longer has permission, go to this User's Crew Identity page.

            // Step 1
            $last_status_from_user = $user->lastStatus();
            //echo "<br /><br />\n\nLast Status: ".$last_status_from_user->id."\n\n<br /><br />\n\n";

            // Step 2
            if(!is_null($last_status_from_user)) {
                $route_params = $last_status_from_user->redirectToNewStatus();

                // Make sure this user is authorized to access this Aircraft or Crew...
                if(Auth::user()->can('act-as-admin-for-crew', $last_status_from_user->crewToUpdate())) {
                    // This User is authorized to access the same resource that was updated last time
                    return redirect()->route($route_params['route_name'], $route_params['id']);
                }
                else {
                    // This aircraft/crew has changed ownership and this user can no longer access it
                    // Redirect to the Crew Identity page
                    return redirect()->route('edit_crew',$user->crew_id);
                }
            }

            // Step 3
            elseif($user->crew->is_not_an_aircraft_crew()) {
                return redirect()->route('new_status_for_crew', $user->crew_id);
            }

            // Step 4|5
            elseif($user->crew->is_an_aircraft_crew()) {
                // Look for the first Aircraft owned by this Crew
                $aircraft = $user->crew->aircrafts()->orderBy('tailnumber')->first();
                if(is_null($aircraft)) {
                    // Step 5 (This crew is supposed to have aircrafts, but none were found)
                    return redirect()->route('edit_crew',$user->crew_id);
                }
                else {
                    // Step 4 (This crew has at least one aircraft)
                    return redirect()->route('new_status_for_aircraft',$aircraft->tailnumber);
                }
            }

            else {
                // The $user is not a GlobalAdmin, nor does he belong to a Crew (this shouldn't happen).
                // Delete the user and display a message.
                // (If the User is not deleted, a new account using the same email cannot be created and a Global Admin
                //  will need to intervene to change the Crew for an existing User).

                $user->delete();
                return redirect()->back()->withErrors("Your crew has been removed from the system. Contact an admin for support.");
            }
        }

    }
}
