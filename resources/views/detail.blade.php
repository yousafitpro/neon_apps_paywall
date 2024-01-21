@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{url('home')}}">Accounts</a>
                    /
                    <a href="{{url('apps',request('api_key'))}}">Apps</a>
                    /
                    <a href="{{url('paywalls')}}/{{request('api_key')}}/{{request('app_id')}}">Paywalls</a>
                    /
                    <a href="javascript:void" style="color: black">Details</a>
                </div>


            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-body">
                <div >
                 <h6 style="text-align: center">Paywall ID</h6>
                </div>

                  <h4 style="text-align: center">{{request('paywall_id')}}</h4>

        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body">

             <h6 style="text-align: center">Updated at</h6>


              <h6 style="text-align: center">{{$paywall->updated_at}}</h6>

    </div>
</div>
<div class="col-md-3">
</div>
<div class="col-md-3">
    <div class="cardcard-body">

         <h6 style="text-align: center">Date</h6>


          <h6 style="text-align: center">{{$paywall->date}}</h6>

</div>
</div>
    </div>
    <br>
<div class="row">
    <div class="col-md-2">
        <div class="card">
            <div class="card-header">
             <h6 style="text-align: center">Total Count</h6>
            </div>
            <div class="card-body" >
              <h4 style="text-align: center">{{$top1['total_count']}}</h4>
            </div>
    </div>
</div>
<div class="col-md-2">
    <div class="card">
        <div class="card-header">
         <h6 style="text-align: center">Trial Converted Count</h6>
        </div>
        <div class="card-body" >
          <h4 style="text-align: center">{{$top1['trialConverted_count']}}</h4>
        </div>
</div>
</div>
<div class="col-md-2">
    <div class="card">
        <div class="card-header">
         <h6 style="text-align: center">Payroll View</h6>
        </div>
        <div class="card-body" >
          <h4 style="text-align: center">0</h4>
        </div>
</div>
</div>
<div class="col-md-2">
    <div class="card">
        <div class="card-header">
         <h6 style="text-align: center">Unique Payroll View</h6>
        </div>
        <div class="card-body" >
          <h4 style="text-align: center">0</h4>
        </div>
</div>
</div>
<div class="col-md-2">
    <div class="card">
        <div class="card-header">
         <h6 style="text-align: center">Initial Purchase Count</h6>
        </div>
        <div class="card-body" >
          <h4 style="text-align: center">{{$top1['initialPurchase_count']}}</h4>
        </div>
</div>
</div>
<div class="col-md-2">
    <div class="card">
        <div class="card-header">
         <h6 style="text-align: center">Renewal Count</h6>
        </div>
        <div class="card-body" >
          <h4 style="text-align: center">{{$top1['renewal_count']}}</h4>
        </div>
</div>
</div>
</div>
    <br>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                         <h6 style="text-align: center">Revenue From Initial Purchase</h6>
                        </div>
                        <div class="card-body" >
                          <h4 style="text-align: center">{{$top2['initialPurchase_amount']}}$</h4>
                        </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                     <h6 style="text-align: center">Revenue From renewal</h6>
                    </div>
                    <div class="card-body" >
                      <h4 style="text-align: center">{{$top2['renewal_amount']}}$</h4>
                    </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                 <h6 style="text-align: center">Total Revenue</h6>
                </div>
                <div class="card-body" >
                  <h4 style="text-align: center">{{$top2['renewal_amount']+$top2['initialPurchase_amount']}}$</h4>
                </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
             <h6 style="text-align: center">Revenue From Trial Converted</h6>
            </div>
            <div class="card-body" >
              <h4 style="text-align: center">{{$top2['trialConverted_amount']}}$</h4>
            </div>
    </div>
</div>

            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">

                            <a href="javascript:void" style="color: black">Products</a>
                        </div>
                        <div class="card-body" style="overflow: auto">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Total Count</th>
                                        <th>renewal</th>
                                        <th>trialStarted</th>
                                        <th>trialConverted</th>
                                        <th>initialPurchase</th>


                                        <!-- Add more columns as needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $item)
                                    <tr class="tbl_row">
                                        <td>{{$item['product_id']}}</td>
                                        <td>{{$item['total_count']}}</td>
                                        <td>{{$item['renewal']}}</td>
                                        <td>{{$item['trialStarted']}}</td>
                                        <td>{{$item['trialConverted']}}</td>
                                        <td>{{$item['initialPurchase']}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">

                            <a href="javascript:void" style="color: black">JSON</a>
                        </div>
                        <div class="card-body" >
                            <textarea style="height:300px;color:green;background-color:black;width:100%">{{$paywall->json}}</textarea>
                        </div>
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
