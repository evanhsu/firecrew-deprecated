<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Domain\Crews\Crew;
use Illuminate\Http\Request;
//use App\Http\Transformers\CrewTransformer;
//use League\Fractal\Manager;

class SummaryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $crews = $this->getData();

        $request->session()->flash('active_menubutton', 'summary'); // Tell the menubar which button to highlight

        return view('summary')->with('crews', $crews);
    }

    public function indexApi(Request $request)
    {
        $crews = $this->getData();

        return $crews->toJson();

//        return $this->response->collection(
//            $crews,
//            new CrewTransformer,
//            ['key' => 'crew'],
//            function ($crews, Manager $fractal) {
//                $fractal->parseIncludes(array_merge(
//                    ['status', 'resources'],
//                    $fractal->getRequestedIncludes()
//                ));
//            }
//        );
    }

    private function getData()
    {
        return Crew::with(['status', 'statusableResources.latestStatus'])->get();
    }
}
