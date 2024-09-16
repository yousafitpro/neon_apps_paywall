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
    <div class="modal " tabindex="-1" role="dialog" id="filterModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content dark-modal">
            <div class="modal-header">
              <h5 class="modal-title">Filters</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
           <form action="{{url('items')}}/{{request('bundle_id')}}?type={{request('type')}}" method="post" id="form_1">
            @csrf
            <input name="form_type" id="form_type" value="records" hidden>
            <input name="sub_type" id="sub_type" value="devices" hidden>
            <div class="row">
                <div class="col-md-12">
                    <select name="year" class="form-control dark-input">
                        <option  value="false">Select year</option>
                        <option {{session('year')=='2024'?'selected':''}} value="2024">This Year</option>
                        <option {{session('year')=='2023'?'selected':''}} value="2023">2023</option>
                        <option {{session('year')=='2022'?'selected':''}} value="2022">2022</option>
                        <option {{session('year')=='2021'?'selected':''}} value="2021">2021</option>
                        <option {{session('year')=='2020'?'selected':''}} value="2020">2020</option>
                    </select>
                </div>
              </div>
              <h6 style="text-align: center">Or</h6>
              <div class="row">
                <div class="col-md-6">
                    <input name="year_start" type="date" value="{{session('year_start')}}" class="form-control dark-input">
                </div>
                <div class="col-md-6">
                    <input name="year_end" type="date" value="{{session('year_end')}}" class="form-control dark-input">
                </div>
              </div>
              <hr color="lightgrey">
              <div class="row">
                <div class="col-md-12">
                    <label>Select Models</label>
                    <select name="device_model[]"  class="form-control dark-input js-example-basic-single" multiple>
                        <option value="">All Models</option>
                        @foreach ($device_models as $model )
                        <option {{session('device_model')==$model->device_model?'selected':''}} value="{{$model->device_model}}">{{$model->device_model}}</option>
                        @endforeach

                    </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                    Is Trial Start
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-switch" style="float:right">
                        <input name="is_trialt_start" {{session('is_trialt_start','false')=='true'?'checked':''}} type="checkbox" class="custom-control-input" id="is_trialt_start" >
                        <label class="custom-control-label" for="is_trialt_start" style="zoom: 1.3"></label>
                      </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                    Is Onoarding Completed
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-switch" style="float:right">
                        <input name="is_onboarding_complete" {{session('is_onboarding_complete','false')=='true'?'checked':''}} type="checkbox" class="custom-control-input" id="is_onboarding_complete" >
                        <label class="custom-control-label" for="is_onboarding_complete" style="zoom: 1.3"></label>
                      </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                    Is Directly Subscribed
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-switch" style="float:right">
                        <input name="is_directly_subscribed" {{session('is_directly_subscribed','false')=='true'?'checked':''}} type="checkbox" class="custom-control-input" id="is_directly_subscribed" >
                        <label class="custom-control-label" for="is_directly_subscribed" style="zoom: 1.3"></label>
                      </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                    Is Trial Converted
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-switch" style="float:right">
                        <input name="is_trialt_converted" {{session('is_trialt_converted','false')=='true'?'checked':''}} type="checkbox" class="custom-control-input" id="is_trialt_converted" >
                        <label class="custom-control-label" for="is_trialt_converted" style="zoom: 1.3"></label>
                      </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                    <button type="button" onclick="submitForm('records')" class="btn btn-info btn-block">Apply</button>
                </div>
              </div>
           </form>
            </div>

          </div>
        </div>
      </div>
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

                        <label onclick="submitForm('export')" style="cursor: pointer"  class="btn btn-secondary {{request('type')=='devices'?'active':''}}">
                          <input type="radio" name="options" id="option1" autocomplete="off" checked> Export
                        </label>
                        <label data-target="#filterModal" data-toggle="modal" style="cursor: pointer"  class="btn btn-secondary {{request('type')=='events'?'active':''}}">
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
    function submitForm(type)
    {
        $('#form_type').val(type)
        $('#form_1').submit()
    }
</script>
@endsection
