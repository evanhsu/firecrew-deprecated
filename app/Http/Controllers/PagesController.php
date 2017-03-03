<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * PagesController
 *
 * This controller is intended to direct visitors to the blade view for the page
 * they're visiting.  No data is loaded by this controller as the React frontend will
 * make calls to the API endpoints once the container page has loaded.
 */
class PagesController extends Controller
{
    public function inventory($item)
    {
        return view('items.index');
    }
}
