@extends('layouts.app')

@section('content')
<style>

    </style>
<div class="container" >

    @foreach ($list as $item)
    <h3 style="color: white"><a href="{{url('home')}}"><span class="btn_back">
        <i class="fa-solid fa-chevron-left"></i></span></a>{{$item->info->app_name}} <a href="https://apps.apple.com/us/app/photos/id{{$item->info->app_id}}" target="_blank" class="d-inline-block">
            <button class="btn btn-success round btn-sm" style="border-radius: 15px;"><i class="fa-solid fa-link"></i> Product Link</button>
        </a>
    </h3>
    <div class="row" style="cursor: pointer">
        <div class="col-md-12">
            <div class="mcard" >
                <div class="mcardbody">

                    <div class="row mytop">
                        <div class="col-md-2 light_purple">
                            <label>Bundle ID</label> <i style="color: white;zoom:1.2; margin-left:5px;" class="fa-solid fa-copy copy-icon" data-clipboard-target="#bundle-id"></i>
                            <br>
                            <small id="bundle-id" style="font-size: 12px">{{$item->info->bundle_id}}</small>
                        </div>
                        <div class="col-md-2 light_blue">
                            <label>App ID</label> <i style="color: white;zoom:1.2; margin-left:5px;" class="fa-solid fa-copy copy-icon" data-clipboard-target="#app-id"></i><br>
                            <small id="app-id">{{$item->info->app_id}}</small>
                        </div>
                        <div class="col-md-2 light_red">
                            <label>Onboarding Completion Rate</label><br>
                            <small>%{{$item->onboarding}}</small>
                        </div>
                        <div class="col-md-2 light_blue">
                            <label>Trial Start Rate</label><br>
                            <small>%{{$item->trial_started}}</small>
                        </div>
                        <div class="col-md-2 light_blue">
                            <label>Trial Converted</label><br>
                            <small>%{{$item->trial_converted}}</small>
                        </div>
                        <div class="col-md-2 light_blue">
                            <label>Direct Subscription Rate</label><br>
                            <small>%{{$item->directly_subscribed}}</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
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
            <input name="sub_type" id="sub_type" value="events" hidden>
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
              <br>
              <div class="row">

                <div class="col-md-12">
                    <label>Group By</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" style="width: 100%" >
                    <label style="cursor: pointer"  class="btn btn-secondary {{(session('group_by')=='none' || session('group_by')=='false')?'active':''}}">
                        <input type="radio"  value="none" {{(session('group_by')=='none' || session('group_by')=='false')?'checked':''}} name="group_by" id="group_none" autocomplete="off" checked> None
                      </label>
                      <label style="cursor: pointer"  class="btn btn-secondary {{session('group_by')=='year'?'active':''}}">
                        <input type="radio" value="year" {{session('group_by')=='year'?'checked':''}} name="group_by" id="group_year" autocomplete="off"> Year
                      </label>
                      <label style="cursor: pointer"  class="btn btn-secondary {{session('group_by')=='month'?'active':''}}">
                        <input type="radio" value="month" {{session('group_by')=='month'?'checked':''}} name="group_by" id="group_month" autocomplete="off"> Month
                      </label>
                       <label style="cursor: pointer"  class="btn btn-secondary {{session('group_by')=='week'?'active':''}}">
                        <input type="radio" value="week" {{session('group_by')=='week'?'checked':''}} name="group_by" id="group_week" autocomplete="off"> Week
                      </label>
                      <label style="cursor: pointer"  class="btn btn-secondary {{session('group_by')=='day'?'active':''}}">
                        <input type="radio" value="day" {{session('group_by')=='day'?'checked':''}} name="group_by" id="group_day" autocomplete="off"> Day
                      </label>
                    </div>
                </div>

              </div>
              <br>
              <div class="row">

                <div class="col-md-12">
                    <label>Search For</label>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" style="width: 100%" >
                    <label style="cursor: pointer"  class="btn btn-secondary {{(session('event_type')=='number'||session('event_type')=='false')?'active':''}}">
                        <input type="radio" value="number" {{(session('event_type')=='number'||session('event_type')=='false')?'checked':''}}  name="event_type" id="event_number" autocomplete="off" checked> # Number Of Events
                      </label>
                      <label style="cursor: pointer"  class="btn btn-secondary {{session('event_type')=='ration'?'active':''}}">
                        <input type="radio" value="ration" {{session('event_type')=='ration'?'checked':''}} name="event_type" id="event_ration" autocomplete="off"> Ratio Of Events
                      </label>

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
                       @if(session('group_by')=='none' || session('group_by')=='false')
                       <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Event Name</th>
                            <th>Event Date</th>

                            <th>Device ID</th>


                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $item)
                        <tr class="tbl_row">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->event_name}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->device_id}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                    @else
                    <thead>
                        <tr>

                            <th>Event Date</th>
                            <th> {{session('event_type')=='number'?'#':''}} Onboarding Completion {{session('event_type')=='ration'?' Rate':''}}</th>
                            <th> {{session('event_type')=='number'?'#':''}} Trial Start {{session('event_type')=='ration'?' Rate':''}}</th>
                            <th>{{session('event_type')=='number'?'#':''}} Trial To Paid {{session('event_type')=='ration'?' Rate':''}}</th>
                            <th> {{session('event_type')=='number'?'#':''}} Direct Subscription {{session('event_type')=='ration'?' Rate':''}}</th>



                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group_by as $item)
                        <tr class="tbl_row">
                            <td>
                                @if(session('group_by')=='month' || session('group_by')=='week')
                                {{$item['start_date']}}/{{$item['end_date']}}
                                @else
                                {{$item['start_date']}}
                                @endif
                            </td>
                            <td>
                                @if(session('event_type')=='ration')
                                %{{$item['is_onboarding_completed']['ration']}}
                                @else
                                {{$item['is_onboarding_completed']['number']}}
                                @endif
                            </td>
                            <td>
                                @if(session('event_type')=='ration')
                                %{{$item['is_trial_started']['ration']}}
                                @else
                                {{$item['is_trial_started']['number']}}
                                @endif
                            </td>
                            <td>
                                @if(session('event_type')=='ration')
                                %{{$item['to_be_paid']['ration']}}
                                @else
                                {{$item['to_be_paid']['number']}}
                                @endif
                            </td>
                            <td>
                                @if(session('event_type')=='ration')
                               % {{$item['is_directly_subscribed']['ration']}}
                                @else
                                {{$item['is_directly_subscribed']['number']}}
                                @endif
                            </td>

                        </tr>

                        @endforeach
                    </tbody>
                       @endif
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
        function submitForm(type)
    {
        $('#form_type').val(type)
        $('#form_1').submit()
    }
    $(document).ready(function() {
        $('#yourDataTable').DataTable({
            order:[]
        }); // Replace 'yourDataTable' with the actual ID of your table
    });
</script>
@endsection
