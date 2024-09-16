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
   <div style="height: 50px;width:100%">
    <div style="float: left;">
        <h4 style="color: white;float:left;"><a href="{{url('home')}}"><span class="btn_back"><i class="fa-solid fa-list"></i></span></a>All Apps</h4>
    <button style="margin-left: 20px" type="button" class="btn btn-info btn-sm rounded" onclick="takeAction('export')">Export</button>
    <button style="margin-left: 5px" type="button" class="btn btn-danger btn-sm rounded" onclick="takeAction('delete')">Delete</button>
    </div>
    <div class="btn-group btn-group-toggle" data-toggle="buttons" style="float: right">
           <label style="color: white; margin-right:10px;display:none" id="selected_item_count">0 items selected</label>
        <button id="selectAll" class="btn btn-info btn-sm rounded" style="margin-right: 10px">Select All</button>
            <button id="cancelAll" style="display:none" class="btn btn-danger btn-sm rounded">Cancel</button>


      </div>
   </div>
    @foreach ($list as $item)


        <div class="row" style="cursor: pointer">
            <div class="col-md-12">
                <div class="mcard" >
                    <div class="mcardbody">
                        <div class="row">
                            <div class="col-md-6">

                                <h5 style="color: white">
                                  {{$item->info->app_name}}
                                  <a class="badge badge-success" href="https://apps.apple.com/us/app/photos/id{{$item->info->app_id}}" target="_blank">
                                    Product Link
                                        </a>
                                </h3>


                            </div>
                            <div class="col-md-6">
                                <div style="float: right; padding:10px;">
                                    {{-- this is for to select the item --}}
                                    <input type="checkbox" class="select-item" value="{{ $item->id }}" style="zoom: 1.5">
                                </div>
                            </div>
                        </div>
                        <a href="{{url('items')}}/{{$item->bundle_id}}?type=devices">
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
                    </a>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

</div>
<form id="downloadForm" method="POST" action="{{ url('home') }}" style="display: none;">
    @csrf
    <input type="hidden" name="type" id="action_type" value="records">
    <input type="hidden" name="items" id="downloadItems">
</form>
<script>
    $(document).ready(function() {
             // Select All Items
             $('#selectAll').on('click', function() {
            $('.select-item').prop('checked', true);
            updateSelectedCount()
        });

        // Cancel All Items
        $('#cancelAll').on('click', function() {
            $('.select-item').prop('checked', false);
            updateSelectedCount()
        });

        // Handle Submit Selected Items

        $('#yourDataTable').DataTable({
            order:[]
        }); // Replace 'yourDataTable' with the actual ID of your table
    });
    function takeAction(action_type) {
        $('#action_type').val(action_type);
    let selectedItems = [];
    $('.select-item:checked').each(function() {
        selectedItems.push($(this).val());
    });

    if (selectedItems.length > 0) {

            if(confirm("Are you sure you want to "+action_type+"?"))
            {
                $('#downloadItems').val(JSON.stringify(selectedItems));

            $('#downloadForm').attr('action', "{{ url('home') }}");
            $('#downloadForm').submit();
            }

    } else {
        alert('Please select at least one item');
    }
}
$('.select-item').on('change', function() {
            updateSelectedCount();
        });
function updateSelectedCount() {
            var selectedCount = $('.select-item:checked').length;
            $('#selected_item_count').text(selectedCount + ' items selected');
            if(selectedCount>0)
            {
                $('#cancelAll').css("display",'block')
                $('#selected_item_count').css("display",'block')
            }else
            {
                $('#cancelAll').css("display",'none')
                $('#selected_item_count').css("display",'none')
            }

        }
</script>
@endsection
