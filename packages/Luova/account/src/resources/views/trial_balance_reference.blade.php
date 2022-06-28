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
                        Trial Balance of {{$mdata->title}}

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
                                @foreach ($mdata->accounts as $key => $list)
                                
                               @php  
                                $debit = $list->ledgers()->sum('debit');
                                $credit = $list->ledgers()->sum('credit');
                               @endphp
                             
                                <tr>
                                    <td style="width: 10px">{{ $key +1 }}</td>
                                    <td>
                                        <a href="{{ route('account.ledger.individual', $list->id) }}">
                                        {{ $list->title }}
                                        </a>
                                    </td>
                                    
                                    <td>{{ money($debit) }}</td>
                                    <td>{{ money($credit) }}</td>
                                    <td>{{ money($credit - $debit) }}</td>

                                </tr>
                                @endforeach
                            </tbody>

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