@extends('layouts.app')

@section('content')
<style>

    </style>
<div class="container" >

    @foreach ($list as $item)
<h3 style="color: white"><a href="{{url('home')}}"><span class="btn_back"><i class="fa-solid fa-chevron-left"></i></span></a>{{$item->info->app_name}}</h3>
    <a href="{{url('items')}}/{{$item->bundle_id}}?type=devices">
        <div class="row" style="cursor: pointer">
            <div class="col-md-12">
                <div class="mcard" >
                    <div class="mcardbody">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 style="color: white">

                                </h3>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Bundle ID</label><br>
                                <small>{{$item->info->bundle_id}}</small>
                            </div>
                            <div class="col-md-1">
                                <label>App ID</label><br>
                                <small>{{$item->info->app_id}}</small>
                            </div>
                            <div class="col-md-2">
                                <label>Onboarding Completion Rate</label><br>
                                <small>%{{$item->onboarding}}</small>
                            </div>
                            <div class="col-md-2">
                                <label>Trial Start Rate</label><br>
                                <small>%{{$item->trial_started}}</small>
                            </div>
                            <div class="col-md-2">
                                <label>Trial Converted</label><br>
                                <small>%{{$item->trial_converted}}</small>
                            </div>
                            <div class="col-md-2">
                                <label>Direct Subscription Rate</label><br>
                                <small>%{{$item->directly_subscribed}}</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    @endforeach
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card table_card">

                <div class="card-body" style="overflow: auto">
                    <div style="width:100%">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" style="float: left">
                        <?php
                            $url1='items/'.request('bundle_id').'?type=devices';
                            $url2='items/'.request('bundle_id').'?type=events';
                            ?>
                        <label style="cursor: pointer" onclick="redirect_me('{{url($url1)}}')" class="btn btn-secondary {{request('type')=='devices'?'active':''}}">
                          <input type="radio" name="options" id="option1" autocomplete="off" checked> Devices
                        </label>
                        <label style="cursor: pointer" onclick="redirect_me('{{url($url2)}}')" class="btn btn-secondary {{request('type')=='events'?'active':''}}">
                          <input type="radio" name="options" id="option3" autocomplete="off"> Events
                        </label>
                      </div>
                      <div class="btn-group btn-group-toggle" data-toggle="buttons" style="float: right">

                        <label style="cursor: pointer"  class="btn btn-secondary {{request('type')=='devices'?'active':''}}">
                          <input type="radio" name="options" id="option1" autocomplete="off" checked> Export
                        </label>
                        <label style="cursor: pointer"  class="btn btn-secondary {{request('type')=='events'?'active':''}}">
                          <input type="radio" name="options" id="option3" autocomplete="off">
                          <i class="fa-solid fa-filter"></i>
                        </label>
                      </div>
                    </div>

                      <br>
                      <br>
                      <br>




                      <table id="yourDataTable">
                        <thead>
                            <tr>
                                <th>device_id</th>
                                <th>idfa</th>
                                <th>Modal</th>
                                <th>Created_at</th>
                                <th>Is Trial Started</th>
                                <th>Is Onboarding Completed</th>
                                <th>Is Directly Subscribed</th>
                                <th>Is Trial Converted</th>


                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devices as $item)
                            <tr class="tbl_row">
                                <td>{{$item->device_id}}</td>
                                <td>{{$item->idfa}}</td>
                                <td>{{$item->device_model}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>@include('components.yes_no_btn',['yes_no'=>$item->is_trial_started])</td>
                                <td>@include('components.yes_no_btn',['yes_no'=>$item->is_onboarding_completed])</td>
                                <td>@include('components.yes_no_btn',['yes_no'=>$item->is_directly_subscribed])</td>
                                <td>@include('components.yes_no_btn',['yes_no'=>$item->is_trial_converted])</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#yourDataTable').DataTable({
            order:[]
        }); // Replace 'yourDataTable' with the actual ID of your table
    });
</script>
@endsection
