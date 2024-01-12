@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">

                    <table id="yourDataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>API Key</th>
                                <th>AppID</th>
                                <th>JSON</th>

                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                            <tr>
                                <td>{{$item->custom_id}}</td>
                                <td>{{$item->api_key}}</td>
                                <td>{{$item->appID}}</td>
                                <td>
                                    <textarea style="height: 100px;color:green; background-color:black">{{$item->json}}</textarea>
                                </td>
                                <!-- Add more rows and data as needed -->
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
