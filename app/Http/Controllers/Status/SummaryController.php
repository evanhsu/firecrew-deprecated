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
        $modifiedCrews = $crews->map(function ($crew) {
            $mostRecentTimestamp = $crew->status->updated_at;

            if (!is_null($crew->statusableResources)) {
                $crew->statusableResources->each(function ($resource) use (&$mostRecentTimestamp) {
                    if ($resource->latestStatus->updated_at->gt($mostRecentTimestamp)) {
                        $mostRecentTimestamp = $resource->latestStatus->updated_at;
                    }
                });
                $crew->status->updated_at = $mostRecentTimestamp;
            }
            return $crew;
        });

        return $modifiedCrews->toJson();

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
