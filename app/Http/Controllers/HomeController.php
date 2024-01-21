<?php

namespace App\Http\Controllers;

use App\Models\Paywall;
use Illuminate\Http\Request;

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
        $data['list'] = Paywall::whereIn('id', function ($query) {
            $query->select(\DB::raw('MAX(id)'))
                ->from('paywalls')
                ->groupBy('api_key');
        })
        ->orderBy('updated_at', 'DESC')
        ->get();
        foreach($data['list'] as $item)
        {
            $item->id=$item->id;
            $item->session_count=Paywall::where([
                'api_key'=>$item->api_key,
                'userID'=>$item->userID,
                'appID'=>$item->appID,
            ])->get()->count();
            $item->paywall_view_count=Paywall::where([
                'api_key'=>$item->api_key,
                'userID'=>$item->userID,
                'appID'=>$item->appID,
                'custom_id'=>$item->paywall_id,
            ])->get()->count();
            $item->paywall_count=Paywall::where([
                'custom_id'=>$item->paywall_id,
            ])->get()->count();

            $item->trialStarted=Paywall::where([
                'type'=>'trialStarted',
            ])->get()->count();

            $item->trialConverted=Paywall::where([
                'type'=>'trialConverted',
            ])->get()->count();

            $item->initialPurchase=Paywall::where([
                'type'=>'initialPurchase',
            ])->get()->count();

            $item->renewal=Paywall::where([
                'type'=>'renewal',
            ])->get()->count();
        }
        return view('home',$data);
    }
    public function apps($id)
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
