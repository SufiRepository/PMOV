<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GanttTask;
use App\Models\LinkModel;

class GanttController extends Controller
{

    public function index($projectId = null){

        if (!$item = GanttTask::find($projectId)) {
            
            return view('gantt-chart.create');
        }
        return view('gantt-chart.create');
        
    }

    public function get($projectId = null)
    { $tasks = new GanttTask;

        // if($tasks->projectid == $id){
        $tasks = new GanttTask();
        $links = new LinkModel();

        // $test = [
        //     "data" => $tasks->all(),
        //     "links" => $links->all()
        // ];

        // dd($test);
 
        return response()->json([
            "data" => $tasks->all(),
            "links" => $links->all()
        ]);
        // }
    }
}
