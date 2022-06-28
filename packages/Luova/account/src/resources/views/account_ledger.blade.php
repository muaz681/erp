@extends('layouts.master')
@section('title', ' Ledger of '.$mdata->title)
@section('content')

@php 
$raw_ledgers = $ledgers =  $mdata->ledgers();
$ledgers =  $raw_ledgers->orderBy('created_at', 'DESC')->paginate(50);

$total_debit = $raw_ledgers->sum('debit');
$total_credit = $raw_ledgers->sum('credit');
$balance = 0;
$total_balance = 0;

if($mdata->head->type == 'Asset' || $mdata->head->type == 'Expense'){
    $total_balance = $total_debit - $total_credit;
}elseif($mdata->head->type == 'Liability' || $mdata->head->type == 'Income') {
    $total_balance = $total_credit - $total_debit;
}


 @endphp


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
      
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Ledger of <b>{{$mdata->title}}</b><br> Balance: <b>{{ money($total_balance) }}</b>

                        <strong class="float-right">{{$mdata->head->type}}</strong>

                    </div>
                   

                    <!-- /.card-header -->
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Account Head</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>

                                </tr>
                            </thead>
                            <tbody>

                                
                                @foreach ($ledgers as $key => $list)

                                @php 
                                if($mdata->head->type == 'Asset' || $mdata->head->type == 'Expense'){
                                    $total = $list->debit - $list->credit;
                                }elseif($mdata->head->type == 'Liability'  || $mdata->head->type == 'Income') {
                                    $total = $list->credit - $list->debit;
                                }

                       
                                $balance += $total;
                                @endphp
                                <tr>
                                    <td style="width: 10px">{{ $key +1 }}</td>
                                    <td>
                                        <a href="{{ route('account.journal.detail', $list->journal_id) }}">
                                        {{ $list->journal->narration }}
                                        </a>
                                    </td>
                                    
                                    <td>{{ money($list->debit) }}</td>
                                    <td>{{ money($list->credit) }}</td>
                                    <td>{{money($balance)}}</td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $ledgers->links() }}
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