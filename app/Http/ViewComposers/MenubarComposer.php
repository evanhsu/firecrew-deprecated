<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MenubarComposer
{

    /**
     * @var String
     */
    protected $menubar_type;
    protected $active_menubutton;

    /**
     *
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        // Determine which Controller Action requested the view
        /*        $action = $route->getActionName(); // e.g. App\Http\Controllers\Auth\AuthController@getLogin
                $method = explode('@',$action)[1]; // e.g. getLogin
                switch($method) {
                    default:
                        $this->active_menubutton = 'map';
                        break;
                }
        */
        $this->active_menubutton = $request->session()->get('active_menubutton');

        // Determine which menubar View to display depending on user account type
        if (Auth::check()) {
            if (Auth::user()->isGlobalAdmin()) {
                // User is a Global Admin
                $this->menubar_type = 'admin';
                $this->crew_id = null;
            } else {
                // User is logged in, but not an admin
                $this->menubar_type = 'user';
                $this->crew_id = Auth::user()->crew_id;
            }
        } else {
            // User is not logged in
            $this->menubar_type = 'guest';
            $this->crew_id = null;
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(array('menubar_type' => $this->menubar_type,
            'active_menubutton' => $this->active_menubutton,
            'user_crew_id' => $this->crew_id));
    }

}

?>