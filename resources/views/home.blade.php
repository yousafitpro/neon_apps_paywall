@extends('layouts.app')

@section('content')
<style>
    .mcard{
        margin-top: 10px;
        background-color: #25272A;
        width: 100%;
        min-height: 100px;
        border-radius: 20px;
        padding: 8px;
    }
    .mcard label{
        color: #809FB8
    }
    .mcard small{
        color: white
    }
    </style>
<div class="container" >
    <div class="row">
        <div class="col-md-3">
            <div class="mcard" style="border-radius: 10px" >
                <div class="mcardbody">
                    <h4 style="color: white">
                        {{$total_apps}}
                    </h3>
                    <label>Total Apps</label>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mcard" style="border-radius: 10px" >
                <div class="mcardbody">
                    <h4 style="color: white">
                        {{$total_devices}}
                    </h3>
                    <label>Total Devices</label>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mcard" style="border-radius: 10px" >
                <div class="mcardbody">
                    <h4 style="color: white">
                        {{$total_users}}
                    </h3>
                    <label>Total Users</label>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mcard" style="border-radius: 10px" >
                <div class="mcardbody">
                    <h4 style="color: white">
                        {{$total_events_count}}
                    </h3>
                    <label>Total Events</label>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h4 style="color: white">All Apps</h4>
    @foreach ($list as $item)

    <a href="{{url('items')}}/{{$item->bundle_id}}?type=devices">
        <div class="row" style="cursor: pointer">
            <div class="col-md-12">
                <div class="mcard" >
                    <div class="mcardbody">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 style="color: white">
                                  {{$item->info->app_name}}
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
                            <div class="col-md-1">
                                <label>Trial Converted</label><br>
                                <small>%{{$item->trial_converted}}</small>
                            </div>
                            <div class="col-md-2">
                                <label>Direct Subscription Rate</label><br>
                                <small>%{{$item->directly_subscribed}}</small>
                            </div>
                            <div class="col-md-2">
                                <label>Registered Device Count</label><br>
                                <small>{{$item->registered_device_count}}</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    @endforeach

</div>
<script>
    $(document).ready(function() {
        $('#yourDataTable').DataTable({
            order:[]
        }); // Replace 'yourDataTable' with the actual ID of your table
    });
</script>
@endsection
