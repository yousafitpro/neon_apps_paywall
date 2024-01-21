@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{url('home')}}">Accounts</a>
                    /
                    <a href="{{url('apps',request('api_key'))}}">Apps</a>
                    /
                    <a href="javascript:void" style="color: black">Paywalls</a>
                </div>

                <div class="card-body" style="overflow: auto">

                    <table id="yourDataTable">
                        <thead>
                            <tr>
                                <th>Paywalls</th>
                                <th>Session Count</th>
                                <th>Paywall View Count</th>
                                <th>renewal</th>
                                <th>trialStarted</th>
                                <th>trialConverted</th>
                                <th>Paywall Count</th>
                                <th>initialPurchase</th>
                                <th>Actions</th>

                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            <tr class="tbl_row">
                                <td>{{$item->custom_id}}</td>
                                <td>{{$item->session_count}}</td>
                                <td>{{$item->paywall_view_count}}</td>
                                <td>{{$item->renewal}}</td>
                                <td>{{$item->trialStarted}}</td>
                                <td>{{$item->trialConverted}}</td>
                                <td>{{$item->paywall_count}}</td>
                                <td>{{$item->initialPurchase}}</td>
                                <td>
                                    <br>
                                    <a class="btn btn-primary btn-block"  href="{{url('paywalls/details')}}/{{request('api_key')}}/{{request('app_id')}}/{{$item->custom_id}}" style="padding:10px;border-radius:10px">Details</a>
                                    <br>
                                    <br>
                                </td>
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
