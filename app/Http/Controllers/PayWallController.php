<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaywallsResource;
use App\Models\Paywall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayWallController extends Controller
{


    public function createPaywall(Request $request)
    {

       $validator= Validator::make($request->all(),['api_key'=>'required','id'=>'required','json'=>'required']);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(Paywall::where('api_key',$request->api_key)->where('deleted_at',null)->where('custom_id',$request->id)->exists())
       {
        return response()->json(['status'=>'error','message'=>"ID already exists"]);
       }

        try{
            $input=$request->all();
            $paywall=Paywall::create([
                'json'=>json_encode($input['json']),
                'custom_id'=>$input['id'],
                'appID'=>$input['appID'],
                'api_key'=>$input['api_key']
            ]);
            return response()->json(['status'=>'success']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
    public function updatePaywall(Request $request)
    {
        $validator= Validator::make($request->all(),['api_key'=>'required','id'=>'required','json'=>'required']);
        if($validator->fails())
        {
         return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
        }
        try{
            $input=$request->all();
            $paywall=Paywall::updateOrCreate(['custom_id'=>$input['id'],'api_key'=>$request->api_key],[
                'json'=>json_encode($input['json']),
                'appID'=>$input['appID']
            ]);
            return response()->json(['status'=>'success']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
    public function getPaywall(Request $request)
    {
        try{
            $input=$request->all();
            if(!Paywall::where('custom_id',$input['id'])->where('deleted_at',null)->where('api_key',$request->api_key)->exists())
            {
                return response()->json(['mesasge'=>"Does Not Exist"]);
            }

            $paywall=Paywall::where('custom_id',$input['id'])->where('deleted_at',null)->where('api_key',$request->api_key)->get()->first();
            return response()->json(['json'=>json_decode($paywall['json'])]);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
    public function getPaywalls(Request $request)
    {
        try{
            $input=$request->all();

            $paywall=Paywall::where('api_key',$request->api_key)->orderBy('updated_at', 'DESC')->get();
            return  response()->json([
                'status' =>'success',
                'paywalls'=>PaywallsResource::collection($paywall)
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
    public function deletePaywall(Request $request)
    {
        try{
            $input=$request->all();
            $paywall=Paywall::where('custom_id',$input['id'])->where('api_key',$request->api_key)->delete();
            return response()->json(['status'=>'success']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
}
