@extends('layouts.master')
@section('title', ' Trial Balance')
@section('content')


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Trial Balance

                        <a class="btn btn-danger float-right" href="?type=print" target="_blank">Print</a>

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

                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $total_debit = 0;
                                    $total_credit = 0;
                                @endphp
                                @foreach ($mdata as $key => $list)
                                
                               
                             
                                <tr>
                                    <td style="width: 10px">{{ $key +1 }}</td>
                                    <td>
                                        <a href="{{ route('account.trial.balance.reference',$list->id)}}">
                                        {{ $list->title }}
                                        </a>
                                    </td>
                                    <td>{{ money($list->debit_sum) }}</td>
                                    <td>{{ money($list->credit_sum) }}</td>
                                    @php 
                                    $total_debit += $list->debit_sum;
                                    $total_credit += $list->credit_sum;
                                @endphp
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                
                                    <th>{{ money($total_debit) }}</th>
                                    <th>{{ money($total_credit) }}</th>

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