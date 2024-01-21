@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{url('home')}}">Accounts</a>
                    /
                    <a style="color: black" href="javascript:void">Apps</a>
                </div>

                <div class="card-body" style="overflow: auto">

                    <table id="yourDataTable">
                        <thead>
                            <tr>
                                <th>Apps</th>
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
                                <td>{{$item->appID}}</td>
                                <td>{{$item->session_count}}</td>
                                <td>{{$item->paywall_view_count}}</td>
                                <td>{{$item->renewal}}</td>
                                <td>{{$item->trialStarted}}</td>
                                <td>{{$item->trialConverted}}</td>
                                <td>{{$item->paywall_count}}</td>
                                <td>{{$item->initialPurchase}}</td>
                                <td>
                                    <br>
                                    <a class="btn btn-primary btn-block"  href="{{url('paywalls')}}/{{$item->api_key}}/{{$item->appID}}" style="padding:10px;border-radius:10px">Paywalls</a>
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
