@extends('layouts.master')
@section('title', ' Journal details')
@section('content')

{{-- @dump($mdata) --}}
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <a href="{{route('account.journal')}}" class="btn btn-sm btn-success">
                            <span class="material-icons">keyboard_backspace</span> Back
                        </a>
                        <a href="?type=print" target="_blank" class="btn btn-sm btn-danger float-right">
                            <span class="material-icons">print</span> Print
                        </a>
                    </div>

                    <!-- /.card-header -->
                  
                </div>
                <!-- /.card -->


            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                       <div class="row">
                           <div class="col-md-6">
                                <b> Voucher Date : </b> {{ ($mdata->created_at)? date('d-M-Y', strtotime($mdata->created_at)):null }}<br>
                                <b> Narration : </b> {{ ($mdata->narration)? $mdata->narration:null }}
                           </div>
                           <div class="col-md-6 text-right">
                           
                            <b>Voucher No : </b> {{ ($mdata->id)? $mdata->id:null }}
                           </div>
                       </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Account</th>
                                    <th>Account Head</th>
                                    <th>Debit</th>
                                    <th>Credit </th>                                 
                                    <th style="">Created At</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                $total_debit = 0;
                                $total_credit = 0;
                            @endphp
                                @foreach($mdata->ledgers as $key => $value)
                                    
                              
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->account->title . ' ['. $value->account->code.']' }}</td>
                                    <td>{{ $value->account->head->title }}</td>
                                    <td style="text-align: right">{{ money($value->debit) }}</td>
                                    <td style="text-align: right">{{ money($value->credit) }}</td>
                                 
                                    <td>{{ ($value->created_at)?date('d-M-Y H:i a',strtotime($value->created_at)): null }}</td>
                                </tr>
                                @php 
                                $total_debit += $value->debit;
                                $total_credit += $value->credit;
                            @endphp
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                 
                                    <th colspan="3" style="text-align: right">Total</th>
                                    <th style="text-align: right">{{ money($total_debit) }}</th>
                                    <th style="text-align: right">{{ money($total_credit) }}</th>                               
                                    <th></th>

                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
                <!-- /.card -->


            </div>
        </div>




        <!-- /.row -->

    </div><!-- /.container-fluid -->
</section>



<!-- ./wrapper -->
@endsection

@push('scripts')


<script>
    $(document).ready(function() {


    });
</script>


@endpush