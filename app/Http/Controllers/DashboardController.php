<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use Auth;
use View;
use App\Models\Asset;
use App\Models\Task;
use App\Models\User;


use App\Models\Client;
use App\Models\Contractor;
use App\Models\Supplier;



/**
 * This controller handles all actions related to the Admin Dashboard
 * for the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class DashboardController extends Controller
{
    /**
    * Check authorization and display admin dashboard, otherwise display
    * the user's checked-out assets.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        // Show the page
        if (Auth::user()->hasAccess('admin')) {

            //task pai chart
           $result=DB::select(DB::raw("SELECT COUNT(*) as task ,statustasks.name  as statusname FROM tasks 
            JOIN statustasks ON tasks.statustask_id= statustasks.id
              WHERE company_id=9  GROUP BY statustask_id") );
        //    dd($result);
        $chartData="";
        foreach($result as $list ){ 
            $chartData.="['".$list->statusname."',".$list->task. "],";
        }
            $arr['chartData']=rtrim($chartData,",");

            //subtask pai chart
            $resultsubtask=DB::select(DB::raw("SELECT COUNT(*) as subtask ,statustasks.name  as statusname FROM subtasks
             JOIN statustasks ON subtasks.statustask_id= statustasks.id  WHERE company_id=9   GROUP BY statustask_id") );
              //    dd($result);
              $chartDataSubtask="";
              foreach($resultsubtask as $list ){ 
                $chartDataSubtask.="['".$list->statusname."',".$list->subtask."],";
            }
            $arr['chartDataSubtask']=rtrim($chartDataSubtask,",");


            $assetcount = new Asset;
            $asset_stats=null;
            $clientcount = new Client;
            $contractorcount = new Contractor;
            $taskcount = new Task;
            $usercount =  new User;
            $suppliercount = new Supplier;
  
            $counts['client']       =  $clientcount          ->count_by_company();
            $counts['contractor']   =  $contractorcount      ->count_by_company();
            $counts['task']         =  $taskcount            ->count_by_company();
            $counts['user']         =  $usercount            ->count_by_company();
            $counts['supplier']     =  $suppliercount        ->count_by_company();

            //$counts['asset'] = \App\Models\Asset::count();
            $counts['asset'] = $assetcount->count_by_company();
            $counts['accessory'] = \App\Models\Accessory::count();
            $counts['license'] = \App\Models\License::assetcount();
            $counts['consumable'] = \App\Models\Consumable::count();
            $counts['project'] = \App\Models\Project::count();
            // $counts['supplier'] = \App\Models\Supplier::count();

            // $counts['client'] = \App\Models\Client::count();
            // $counts['contractor'] = \App\Models\Contractor::count();

            $counts['grand_total'] =  $counts['asset'] +  $counts['accessory'] +  $counts['license'] +  $counts['consumable'];
            
            if ((!file_exists(storage_path().'/oauth-private.key')) || (!file_exists(storage_path().'/oauth-public.key'))) {
                \Artisan::call('migrate', ['--force' => true]);
                \Artisan::call('passport:install');
            }

            return view('dashboard',$arr)->with('asset_stats', $asset_stats)->with('counts', $counts);
        } else {
        // Redirect to the profile page
            return redirect()->intended('account/view-assets');
        }
    }
}
