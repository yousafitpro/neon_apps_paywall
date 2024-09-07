<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceEvent;
use App\Models\Paywall;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function index()
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

        }
        return view('home',$data);
    }
    public function items($bundle_id)
    {


        $data['list'] = Device::where('bundle_id',$bundle_id)
        ->take(1)->get();
        $data['devices'] = Device::where('bundle_id',$bundle_id)
        ->get();
        $data['events'] = DeviceEvent::where('bundle_id',$bundle_id)
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
        if(request('type')=="devices")
        {

            return view('devices',$data);
        }
        if(request('type')=="events")
        {
            return view('events',$data);
        }
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
