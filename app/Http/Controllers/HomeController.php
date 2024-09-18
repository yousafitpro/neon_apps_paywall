<?php

namespace App\Http\Controllers;

use App\Exports\AppExport;
use App\Models\Device;
use App\Models\DeviceEvent;
use App\Models\Paywall;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Exports\DeviceExport;
use App\Exports\EventExport;
use App\Exports\EventV2Export;
use Maatwebsite\Excel\Facades\Excel;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete($id)
    {
           Paywall::where('id',$id)->delete();
           return back()->with(['message'=>"Successfully deleted"]);
    }
    public function index(Request $request)
    {

        $data['total_devices'] = Device::distinct('device_id')
        ->count('device_id');
        $data['total_apps'] = Device::distinct('app_name')
        ->count('app_name');
        $data['list'] = Device::select('bundle_id', DB::raw('MAX(id) as id'))
        ->groupBy('bundle_id')
        ->get();
        $data['total_events_count'] = DeviceEvent::query()->get()->count();
        $data['total_users'] = User::query()->get()->count();

        foreach($data['list'] as $item)
        {
            $item->info=Device::where('bundle_id',$item->bundle_id)->first();


            $total=Device::where('bundle_id',$item->bundle_id)->get()->count();
            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_onboarding_completed','true')->get()->count();
            $item->onboarding=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_trial_started','true')->get()->count();
            $item->trial_started=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_directly_subscribed','true')->get()->count();
            $item->directly_subscribed=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_trial_converted','true')->get()->count();
            $item->trial_converted=($gained/$total)*100;

            $item->registered_device_count = Device::where('bundle_id', $item->bundle_id)
            ->distinct('device_id')
            ->count('device_id');

        }


        if($request->has(key: 'type') && $request->type=='delete')
        {

            Device::destroy(json_decode($request->items,true));
            return redirect()->back()->with(['status'=>'success','message'=>'Records successfully deleted']);
        }
        if($request->has('type') && $request->type=='export')
        {
            $request->merge(['form_type'=>'export','type'=>'devices','sub_type'=>'devices']);
            return self::items($request,json_decode($request->items,true),'home');
        }
        return view('home',$data);
    }
    public function items(Request $request,$bundle_id,$from='same')
    {


        Session::put('is_trialt_converted',$request->has('is_trialt_converted')?'true':'false');
        Session::put('is_directly_subscribed',$request->has('is_directly_subscribed')?'true':'false');
        Session::put('is_onboarding_complete',$request->has('is_onboarding_complete')?'true':'false');
        Session::put('is_trialt_start',$request->has('is_trialt_start')?'true':'false');
        Session::put('device_model',$request->has('device_model')?$request->device_model:'false');
        Session::put('year',$request->has('year')?$request->year:'false');
        Session::put('year_start',$request->has('year_start')?$request->year_start:'false');
        Session::put('year_end',$request->has('year_end')?$request->year_end:'false');
        Session::put('group_by',$request->has('group_by')?$request->group_by:'false');
        Session::put('event_type',$request->has('event_type')?$request->event_type:'false');

        $is_trialt_converted=Session::get('is_trialt_converted');
        $is_directly_subscribed=Session::get('is_directly_subscribed');
        $is_onboarding_complete=Session::get('is_onboarding_complete');
        $is_trialt_start=Session::get('is_trialt_start');
        $device_model=Session::get('device_model');
        $year=Session::get('year');
        $year_start=Session::get('year_start');
        $year_end=Session::get('year_end');
        $event_type=Session::get('event_type');
        $group_by=Session::get('group_by');
        $data['s_event_type']=$event_type;
        $data['s_group_by']=$group_by;
// dd($is_onboarding_complete,$is_trialt_start,$is_directly_subscribed,$is_trialt_converted);
        $data['device_models'] = Device::select('device_model')->where('bundle_id',$bundle_id)->distinct()->get();
        $data['list'] = Device::where('bundle_id',$bundle_id)
        ->take(1)->get();
        $data['devices'] = Device::query()
        ->when($from=='same',function($query)use($bundle_id){
            $query->where('bundle_id',$bundle_id);
        })
        ->when($from=='home',function($query)use($bundle_id){
            $bundles=Device::query()->whereIn('id',$bundle_id)->get('bundle_id')->toArray();
            $query->whereIn('bundle_id',$bundles);
        })
        ->when(($is_onboarding_complete!='false'), function ($query) use ($is_onboarding_complete) {
            $query->where('is_onboarding_completed',$is_onboarding_complete);
        })
        ->when(($is_trialt_start!='false'), function ($query) use ($is_trialt_start) {
            $query->where('is_trial_started',$is_trialt_start);
        })
        ->when(($is_directly_subscribed!='false'), function ($query) use ($is_directly_subscribed) {
            $query->where('is_directly_subscribed',$is_directly_subscribed);
        })
        ->when(($is_trialt_converted!='false'), function ($query) use ($is_trialt_converted) {
            $query ->where('is_trial_converted',$is_trialt_converted);
        })
        ->when(($device_model!='false' && $device_model!=''), function ($query) use ($device_model) {
            $query->whereIn('device_model', $device_model);
        })
        ->when(($year!='false'), function ($query) use ($year) {
            $query->whereYear('created_at', $year);
        })
        ->when(($year=='false' && $year_start!='false' && !empty($year_start)), function ($query) use ($year_start) {
            $query->whereDate('created_at','>=', $year_start);
        })
        ->when(($year=='false' && $year_end!='false' && !empty($year_end)), function ($query) use ($year_end) {
            $query->whereDate('created_at','<=', $year_end);
        })
        ->get();

        $data['events'] = DeviceEvent::where('bundle_id',$bundle_id)
        ->when(($year!='false'), function ($query) use ($year) {
            $query->whereYear('created_at', $year);
        })
        ->when(($year=='false' && $year_start!='false' && !empty($year_start)), function ($query) use ($year_start) {
            $query->whereDate('created_at','>=', $year_start);
        })
        ->when(($year=='false' && $year_end!='false' && !empty($year_end)), function ($query) use ($year_end) {
            $query->whereDate('created_at','<=', $year_end);
        })
        ->get();
        $data['group_by']=[];
        if($group_by=='year')
        {
            $data['group_by'] = DeviceEvent::where('bundle_id', $bundle_id)
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as total_events, MIN(created_at) as start_date, MAX(created_at) as end_date')
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->get()->map(function ($event)use($bundle_id) {
                $year = $event->year;

                // Create start and end dates for the year
                $startDate = \Carbon\Carbon::create($year, 1, 1)->startOfYear();
                $endDate = \Carbon\Carbon::create($year, 12, 31)->endOfYear();

                return [
                    'year' => $year,
                    'is_onboarding_completed'=>self::count_event_ratio_and_number($bundle_id,'is_onboarding_completed',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'is_trial_started'=>self::count_event_ratio_and_number($bundle_id,'is_trial_started',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'is_directly_subscribed'=>self::count_event_ratio_and_number($bundle_id,'is_directly_subscribed',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'to_be_paid'=>self::count_event_ratio_and_number($bundle_id,'is_trial_converted',$startDate->toDateTimeString(),$endDate->toDateTimeString(),'!='),
                    'total_events' => $event->total_events,
                    'start_date' => $startDate->format('Y'),
                    'end_date' => $endDate->format('Y'),
                ];
            });
        }
        if($group_by=='month')
        {
            $data['group_by'] =DeviceEvent::where('bundle_id', $bundle_id)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total_events')
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get()->map(function ($event)use($bundle_id) {
                $year = $event->year;
                $month = $event->month;

                // Create start and end dates for the month
                $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
                $endDate = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();

                return [
                    'is_onboarding_completed'=>self::count_event_ratio_and_number($bundle_id,'is_onboarding_completed',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'is_trial_started'=>self::count_event_ratio_and_number($bundle_id,'is_trial_started',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'is_directly_subscribed'=>self::count_event_ratio_and_number($bundle_id,'is_directly_subscribed',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'to_be_paid'=>self::count_event_ratio_and_number($bundle_id,'is_trial_converted',$startDate->toDateTimeString(),$endDate->toDateTimeString(),'!='),
                    'year' => $year,
                    'month' => $month,
                    'total_events' => $event->total_events,
                    'start_date' => $startDate->format('j F'),
                    'end_date' => $endDate->format('j F'),
                ];
            });
        }
        if($group_by == 'week') {
            $data['group_by'] = DeviceEvent::where('bundle_id', $bundle_id)
                ->selectRaw('YEAR(created_at) as year, WEEK(created_at, 1) as week, COUNT(*) as total_events')
                ->groupBy(DB::raw('YEAR(created_at), WEEK(created_at, 1)'))
                ->get()->map(function ($event) use ($bundle_id) {
                    $year = $event->year;
                    $week = $event->week;

                    // Create start and end dates for the week
                    $startDate = \Carbon\Carbon::now()->setISODate($year, $week)->startOfWeek();
                    $endDate = \Carbon\Carbon::now()->setISODate($year, $week)->endOfWeek();

                    return [
                        'is_onboarding_completed' => self::count_event_ratio_and_number($bundle_id, 'is_onboarding_completed', $startDate->toDateTimeString(), $endDate->toDateTimeString()),
                        'is_trial_started' => self::count_event_ratio_and_number($bundle_id, 'is_trial_started', $startDate->toDateTimeString(), $endDate->toDateTimeString()),
                        'is_directly_subscribed' => self::count_event_ratio_and_number($bundle_id, 'is_directly_subscribed', $startDate->toDateTimeString(), $endDate->toDateTimeString()),
                        'to_be_paid' => self::count_event_ratio_and_number($bundle_id, 'is_trial_converted', $startDate->toDateTimeString(), $endDate->toDateTimeString(), '!='),
                        'year' => $year,
                        'week' => $week,
                        'total_events' => $event->total_events,
                        'start_date' => $startDate->format('j F'),
                        'end_date' => $endDate->format('j F'),
                    ];
                });
        }
        if($group_by=='day')
        {

            $data['group_by'] = DeviceEvent::where('bundle_id', $bundle_id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_events, MIN(created_at) as start_date, MAX(created_at) as end_date')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()->map(function ($event)use($bundle_id) {
                $date = $event->date;

                // Create start and end dates for the day
                $startDate = \Carbon\Carbon::parse($date)->startOfDay();
                $endDate = \Carbon\Carbon::parse($date)->endOfDay();

                return [
                    'is_onboarding_completed'=>self::count_event_ratio_and_number($bundle_id,'is_onboarding_completed',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'is_trial_started'=>self::count_event_ratio_and_number($bundle_id,'is_trial_started',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'is_directly_subscribed'=>self::count_event_ratio_and_number($bundle_id,'is_directly_subscribed',$startDate->toDateTimeString(),$endDate->toDateTimeString()),
                    'to_be_paid'=>self::count_event_ratio_and_number($bundle_id,'is_trial_converted',$startDate->toDateTimeString(),$endDate->toDateTimeString(),'!='),
                    'date' => $date,
                    'total_events' => $event->total_events,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                ];
            });
        }



        foreach($data['list'] as $item)
        {
            $item->info=Device::where('bundle_id',$item->bundle_id)->first();


            $total=Device::where('bundle_id',$item->bundle_id)->get()->count();
            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_onboarding_completed','true')->get()->count();
            $item->onboarding=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_trial_started','true')->get()->count();
            $item->trial_started=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_directly_subscribed','true')->get()->count();
            $item->directly_subscribed=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_trial_converted','true')->get()->count();
            $item->trial_converted=($gained/$total)*100;

        }

        if($request->has('form_type') && $request->form_type=='export' && $request->has('sub_type') && $request->sub_type=='devices')
        {
            return Excel::download(new DeviceExport($data['devices']), 'devices.xlsx');
        }

        if($request->has('form_type') && $request->form_type=='export' && $request->has('sub_type') && $request->sub_type=='events' && (session('group_by')!='none' && session('group_by')!='false'))
        {

            return Excel::download(new EventV2Export($data), 'events.xlsx');
        }
        if($request->has('form_type') && $request->form_type=='export' && $request->has('sub_type') && $request->sub_type=='events')
        {

            return Excel::download(new EventExport($data['events']), 'events.xlsx');
        }
        if(request('type')=="devices")
        {

            return view('devices',$data);
        }
        if(request('type')=="events")
        {
            return view('events',$data);
        }
    }

    public function count_event_ratio_and_number($bundle_id,$event_name,$start_date,$end_date,$expresion='=')
    {
        $total=Device::where('bundle_id',$bundle_id)->get()->count();
        $gained=Device::where('bundle_id',$bundle_id)->where($event_name,$expresion,'true')
        ->whereDate('created_at','>=',$start_date)
        ->whereDate('created_at','<=',$end_date)
        ->get()->count();
        $ratio=($gained/$total)*100;
        return ['ration'=>$ratio,'number'=>$gained];
    }
    public function events($bundle_id)
    {

        $data['total_devices'] = Device::distinct('device_id')
        ->count('device_id');
        $data['total_apps'] = Device::distinct('app_name')
        ->count('app_name');
        $data['list'] = Device::select('bundle_id', DB::raw('MAX(id) as id'))
        ->groupBy('bundle_id')
        ->get();

        foreach($data['list'] as $item)
        {
            $item->info=Device::where('bundle_id',$item->bundle_id)->first();


            $total=Device::where('bundle_id',$item->bundle_id)->get()->count();
            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_onboarding_completed','true')->get()->count();
            $item->onboarding=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_trial_started','true')->get()->count();
            $item->trial_started=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_directly_subscribed','true')->get()->count();
            $item->directly_subscribed=($gained/$total)*100;

            $gained=Device::where('bundle_id',$item->bundle_id)->where('is_trial_converted','true')->get()->count();
            $item->trial_converted=($gained/$total)*100;

        }
        if(request('type')=="devies")
        {
            dd("ok");
            return view('devices',$data);
        }
        if(request('type')=="events")
        {
            return view('events',$data);
        }

    }    public function apps($id)
    {
        $data['list'] = Paywall::whereIn('id', function ($query) {
            $query->select(\DB::raw('MAX(id)'))
                ->from('paywalls')
                ->groupBy('appID');
        })
        ->orderBy('updated_at', 'DESC')
        ->where('api_key',$id)
        ->get();
        foreach($data['list'] as $item)
        {
            $item->session_count=Paywall::where([
                'api_key'=>$id,
                'userID'=>$item->userID,
                'appID'=>$item->appID,
            ])->get()->count();
            $item->paywall_view_count=Paywall::where([
                'api_key'=>$id,
                'userID'=>$item->userID,
                'appID'=>$item->appID,
                'custom_id'=>$item->paywall_id,
            ])->get()->count();
            $item->paywall_count=Paywall::where([
                'custom_id'=>$item->paywall_id,
                'api_key'=>$id,
                'appID'=>$item->appID
            ])->get()->count();

            $item->trialStarted=Paywall::where([
                'type'=>'trialStarted',
                'api_key'=>$id,
                'appID'=>$item->appID
            ])->get()->count();

            $item->trialConverted=Paywall::where([
                'type'=>'trialConverted',
                'api_key'=>$id,
                'appID'=>$item->appID
            ])->get()->count();

            $item->initialPurchase=Paywall::where([
                'type'=>'initialPurchase',
                'api_key'=>$id,
                'appID'=>$item->appID
            ])->get()->count();

            $item->renewal=Paywall::where([
                'type'=>'renewal',
                'api_key'=>$id,
                'appID'=>$item->appID
            ])->get()->count();
        }

        return view('apps',$data);
    }
    public function paywall_details($api_key,$app_id,$paywall_id)
    {

          $data['products']=Paywall::query()->where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id
        ])
        ->orderBy('updated_at', 'DESC')
        ->get()->toArray();
        $main_list=[];
        $new_list=[];
        foreach(get_unique_from_array($data['products']) as $item)
        {
            $new_list['product_id']=$item;
            $new_list['total_count']=Paywall::where([
                'api_key'=>$api_key,
                'appID'=>$app_id,
                'custom_id'=>$paywall_id,
                'productID'=>$item
            ])->get()->count();
            $new_list['renewal']=Paywall::where([
                'api_key'=>$api_key,
                'appID'=>$app_id,
                'custom_id'=>$paywall_id,
                'productID'=>$item,
                'type'=>'renewal'
            ])->get()->count();
            $new_list['trialStarted']=Paywall::where([
                'api_key'=>$api_key,
                'appID'=>$app_id,
                'custom_id'=>$paywall_id,
                'productID'=>$item,
                'type'=>'trialStarted'
            ])->get()->count();
            $new_list['trialConverted']=Paywall::where([
                'api_key'=>$api_key,
                'appID'=>$app_id,
                'custom_id'=>$paywall_id,
                'productID'=>$item,
                'type'=>'trialConverted'
            ])->get()->count();

            $new_list['initialPurchase']=Paywall::where([
                'type'=>'initialPurchase',
                'api_key'=>$api_key,
                'appID'=>$app_id,
                'custom_id'=>$paywall_id,
                'productID'=>$item
            ])->get()->count();
          $main_list[]=$new_list;
          $new_list=[];
        }
        $top1['total_count']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id
        ])->get()->count();
        $top1['renewal_count']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id,
            'type'=>'renewal'
        ])->get()->count();
        $top1['trialStarted_count']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id,
            'type'=>'trialStarted'
        ])->get()->count();
        $top1['trialConverted_count']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id,
            'type'=>'trialConverted'
        ])->get()->count();

        $top1['initialPurchase_count']=Paywall::where([
            'type'=>'initialPurchase',
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id
        ])->get()->count();

        $top2['renewal_amount']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id,
            'type'=>'renewal'
        ])->sum('amount');
        $top2['trialStarted_amount']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id,
            'type'=>'trialStarted'
        ])->sum('amount');
        $top2['trialConverted_amount']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id,
            'type'=>'trialConverted'
        ])->sum('amount');

        $top2['initialPurchase_amount']=Paywall::where([
            'type'=>'initialPurchase',
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id
        ])->sum('amount');

        $data['products']=$main_list;
        $data['top1']=$top1;
        $data['top2']=$top2;
        $data['paywall']=Paywall::where([
            'api_key'=>$api_key,
            'appID'=>$app_id,
            'custom_id'=>$paywall_id
        ])->get()->first();
        return view('detail',$data);
    }
    public function paywalls($id,$app_id)
    {
        $data['list'] = Paywall::whereIn('id', function ($query) {
            $query->select(\DB::raw('MAX(id)'))
                ->from('paywalls')
                ->groupBy('custom_id');
        })
        ->orderBy('updated_at', 'DESC')
        ->where('api_key',$id)
        ->where('appID',$app_id)
        ->get();
        foreach($data['list'] as $item)
        {
            $item->session_count=Paywall::where([
                'api_key'=>$id,
                'userID'=>$item->userID,
                'appID'=>$app_id,
            ])->get()->count();
            $item->paywall_view_count=Paywall::where([
                'api_key'=>$id,
                'userID'=>$item->userID,
                'appID'=>$app_id,
                'custom_id'=>$item->custom_id,
            ])->get()->count();
            $item->paywall_count=Paywall::where([
                'custom_id'=>$item->custom_id,
                'appID'=>$app_id,
                'api_key'=>$id,
            ])->get()->count();
            $item->trialStarted=Paywall::where([
                'type'=>'trialStarted',
                'api_key'=>$id,
                'appID'=>$app_id,
                'custom_id'=>$item->custom_id
            ])->get()->count();

            $item->trialConverted=Paywall::where([
                'type'=>'trialConverted',
                'appID'=>$app_id,
                'api_key'=>$id,
                'custom_id'=>$item->custom_id
            ])->get()->count();

            $item->initialPurchase=Paywall::where([
                'type'=>'initialPurchase',
                'appID'=>$app_id,
                'api_key'=>$id,
                'custom_id'=>$item->custom_id
            ])->get()->count();

            $item->renewal=Paywall::where([
                'type'=>'renewal',
                'appID'=>$app_id,
                'api_key'=>$id,
                'custom_id'=>$item->custom_id
            ])->get()->count();
        }

        return view('paywalls',$data);
    }



}
