<?php

namespace App\Http\Controllers;

use App\Models\Paywall;
use Illuminate\Http\Request;
use App\Http\Resources\PaywallsResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\logPaywallViewResource;
use App\Models\Device;

class DeviceController extends Controller
{


    public function create(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required',
        'app_name'=>'required',
        'idfa'=>'required',
        'device_model'=>'required',
        'created_at'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'success','message'=>'Record already exists'],200);
       }
       $data=$request->except('_token');
       Device::create($data);
       return response()->json(['status'=>'success','message'=>'Record Created'],201);
    }
    public function update(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->update($data);
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
    public function trial_start(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->update(
        ['is_trial_started'=>'true']
       );
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
     public function trial_conversion(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->update(
        ['is_trial_converted'=>'true']
       );
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
     public function direct_subscription(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->update(
        ['is_directly_subscribed'=>'true']
       );
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
    public function paywall_view(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->update(
        ['is_paywall_viewed'=>'true']
       );
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
    public
     function onboarding_completion(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id])->update(
        ['is_onboarding_completed'=>'true']
       );
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
}
