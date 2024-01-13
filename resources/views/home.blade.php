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
                                <th>Last Updated</th>
                                <th>Actions</th>

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
                                <td>{{$item->updated_at}}</td>
                                <td>
                                    <a onclick="return confirm('Are you sure?')" href="{{route('paywall.delete',$item->id)}}" style="background-color: darkred;color:white;padding:10px;border-radius:10px">Delete</a>
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
