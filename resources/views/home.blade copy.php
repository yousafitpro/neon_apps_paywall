@extends('layouts.app')

@section('content')

<div class="container" >
    @foreach ($list as $item)
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: gray">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Accounts</div>

                <div class="card-body" style="overflow: auto">

                    <table id="yourDataTable">
                        <thead>
                            <tr>
                                <th>Accounts</th>
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
                                <td>{{$item->api_key}}</td>
                                <td>{{$item->session_count}}</td>
                                <td>{{$item->paywall_view_count}}</td>
                                <td>{{$item->renewal}}</td>
                                <td>{{$item->trialStarted}}</td>
                                <td>{{$item->trialConverted}}</td>
                                <td>{{$item->paywall_count}}</td>
                                <td>{{$item->initialPurchase}}</td>
                                <td>
                                    <br>
                                    <a class="btn btn-primary btn-block"  href="{{route('apps',$item->api_key)}}" style="padding:10px;border-radius:10px">Apps</a>
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
