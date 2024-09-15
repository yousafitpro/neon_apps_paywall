<?php

namespace App\Http\Controllers;

use App\Models\Paywall;
use Illuminate\Http\Request;
use App\Http\Resources\PaywallsResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\logPaywallViewResource;
use App\Models\Device;
use App\Models\DeviceEvent;

class DeviceController extends Controller
{


    public function create(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox'],
        'app_name'=>'required',
        'device_model'=>'required',
        'created_at'=>['required', 'date_format:m/d/Y H:i:s']
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'success','message'=>'Record already exists'],200);
       }
       $data=$request->except('_token');
       Device::create($data);
       return redirect()->back()->with(['status'=>'success','message'=>'Record Created']);
    }
    public function update(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox'],
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->update($data);
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
    public function trial_start(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox'],
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');

       Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->update(
        ['is_trial_started'=>'true']
       );
       DeviceEvent::updateOrCreate(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Trial Started'],
       ['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Trial Started']);
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
     public function trial_conversion(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'bundle_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox']
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->update(
        ['is_trial_converted'=>'true']
       );
       DeviceEvent::updateOrCreate(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Trial Converted'],
       ['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Trial Converted']);
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
     public function direct_subscription(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox'],
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->update(
        ['is_directly_subscribed'=>'true']
       );
       DeviceEvent::updateOrCreate(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Directly Subscribed'],
       ['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Directly Subscribed']);
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
    public function paywall_view(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox'],
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->update(
        ['is_paywall_viewed'=>'true']
       );
       DeviceEvent::updateOrCreate(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Paywall Viewed'],
       ['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Paywall Viewed']);
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
    public function onboarding_completion(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox'],
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->update(
        ['is_onboarding_completed'=>'true']
       );
       DeviceEvent::updateOrCreate(['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Onboarding Completed'],
       ['device_id'=>$request->device_id,'bundle_id'=>$request->bundle_id,'event_name'=>'Onboarding Completed']);
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
    public function track_session(Request $request)
    {

       $validator= Validator::make($request->all(),[
        'device_id'=>'required',
        'environment' => ['required', 'in:Production,Sandbox'],
        'bundle_id'=>'required'
    ]);
       if($validator->fails())
       {
        return response()->json(['status'=>'error','errors'=>$validator->errors()->all()]);
       }
       if(!Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->exists())
       {
        return response()->json(['status'=>'error','message'=>'Record does not exist'],404);
       }
       $data=$request->except('_token');
       $item=Device::where(['device_id'=>$request->device_id,'environment'=>$request->environment,'bundle_id'=>$request->bundle_id])->first();
       $item->session_count=$item->session_count+1;
       $item->save();
       return response()->json(['status'=>'success','message'=>'Record Updated'],200);
    }
}
