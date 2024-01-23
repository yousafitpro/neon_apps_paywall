<?php

namespace App\Http\Controllers;

use App\Models\Paywall;
use Illuminate\Http\Request;
use App\Http\Resources\PaywallsResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\logPaywallViewResource;

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
     public function logConversion(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'api_key'=>'required',
        'userID'=>'required',
        'appID'=>'required',
        'productID'=>'required',
        'type'=>'required',
        'paywall_id'=>'required',
        'date'=>'required',
        'amount'=>'required',
        'json'=>'required'
    ],[
        'userID.required'=>"User ID is Required",
        'productID.required'=>"Product ID is Required",
        'appID.required'=>"App ID is Required",
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(Paywall::where('deleted_at',null)->where([
        'api_key'=>$request->api_key,
        'userID'=>$request->userID,
        'appID'=>$request->appID,
        'custom_id'=>$request->paywall_id,
        'productID'=>$request->productID,
        'date'=>$request->date
        ])->exists())
       {
        return response()->json(['status'=>'error','message'=>"ID already exists"]);
       }

        try{
            $input=$request->all();
            $paywall=Paywall::create([
                'api_key'=>$request->api_key,
                'userID'=>$request->userID,
                'appID'=>$request->appID,
                'productID'=>$request->productID,
                'type'=>$request->type,
                'custom_id'=>$request->paywall_id,
                'date'=>$request->date,
                'amount'=>$request->amount,
                'json'=>isset($input['json'])?json_encode($input['json']):''
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
                'appID'=>$input['appID'],
                'updated_at'=>Now()
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
            return response()->json(['status' =>'success','json'=>json_decode($paywall['json'])]);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
     public function getTemplate(Request $request)
    {
        // try{
            $input=$request->all();
            if(!Paywall::where('custom_id',$input['id'])->where('deleted_at',null)->exists())
            {
                return response()->json(['mesasge'=>"Does Not Exist"]);
            }

            $paywall=Paywall::where('custom_id',$input['id'])->where('deleted_at',null)->get()->first();
            return response()->json(['status' =>'success','json'=>json_decode($paywall['json'])]);
        // }
        // catch(\Exception $e)
        // {
        //     return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        // }
    }
    public function logPaywallView(Request $request)
    {
        try{
            $input=$request->all();
            if(!Paywall::where('deleted_at',null)->where([
                'api_key'=>$request->api_key,
                'userID'=>$request->userID,
                'custom_id'=>$request->paywall_id,
            ])->exists())
            {
                return response()->json(['mesasge'=>"Does Not Exist"]);
            }

            $paywall=Paywall::where('deleted_at',null)->where([
                'api_key'=>$request->api_key,
                'userID'=>$request->userID,
                'custom_id'=>$request->paywall_id,
            ])->get();
            return  response()->json([
                'status' =>'success',
                'paywalls'=>logPaywallViewResource::collection($paywall)
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
     public function logSession(Request $request)
    {
        try{
            $input=$request->all();
            if(!Paywall::where('deleted_at',null)->where([
                'api_key'=>$request->api_key,
                'userID'=>$request->userID,
                'custom_id'=>$request->paywall_id,
            ])->exists())
            {
                return response()->json(['mesasge'=>"Does Not Exist"]);
            }

            $paywall=Paywall::where('deleted_at',null)->where([
                'api_key'=>$request->api_key,
                'userID'=>$request->userID,
                'custom_id'=>$request->paywall_id,
            ])->get();
            return  response()->json([
                'status' =>'success',
                'paywalls'=>logPaywallViewResource::collection($paywall)
            ]);
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
