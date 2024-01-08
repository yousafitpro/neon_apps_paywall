<?php

namespace App\Http\Controllers;

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
       if(Paywall::where('api_key',$request->api_key)->where('custom_id',$request->id)->exists())
       {
        return response()->json(['status'=>'error','message'=>"ID already exists"]);
       }

        try{
            $input=$request->all();
            $paywall=Paywall::create([
                'json'=>json_encode($input['json']),
                'custom_id'=>$input['id'],
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
            $paywall=Paywall::where('custom_id',$input['id'])->where('api_key',$request->api_key)->update([
                'json'=>json_encode($input['json'])
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
            if(!Paywall::where('custom_id',$input['id'])->where('api_key',$request->api_key)->exists())
            {
                return response()->json(['mesasge'=>"Does Not Exist"]);
            }

            $paywall=Paywall::where('custom_id',$input['id'])->where('api_key',$request->api_key)->get()->first();
            return response()->json(['json'=>json_decode($paywall['json'])]);
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
