<?php

namespace App\Http\Controllers;

use App\Models\Paywall;
use Illuminate\Http\Request;

class PayWallController extends Controller
{


    public function createPaywall(Request $request)
    {
        try{
            $input=$request->all();
            $paywall=Paywall::create([
                'json'=>json_encode($input['json'])
            ]);
            return response()->json(['status'=>'success','id'=>$paywall->id]);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
    public function updatePaywall(Request $request)
    {
        try{
            $input=$request->all();
            $paywall=Paywall::where('id',$input['id'])->update([
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
            if(!Paywall::where('id',$input['id'])->exists())
            {
                return response()->json(['mesasge'=>"Does Not Exist"]);
            }

            $paywall=Paywall::where('id',$input['id'])->get()->first();
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
            $paywall=Paywall::where('id',$input['id'])->delete();
            return response()->json(['status'=>'success']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'error','message'=>"Operation Failed"]);
        }
    }
}
