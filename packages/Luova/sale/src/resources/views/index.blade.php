@extends('layouts.master')
@section('title', ' Sales')
@section('content')


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @isset(sale_setting()->cogs)
                        <a href="{{route('sale.add')}}" class="btn btn-sm btn-success">
                            <span class="material-icons">add_circle_outline</span> New sales
                        </a>
                        <a href="{{route('sale.local')}}" class="btn btn-sm btn-danger">
                            <span class="material-icons">add_circle_outline</span> Local sale
                        </a>
                        @endisset
                        <a href="{{route('sale.setting')}}" class=" float-right">
                            <span class="material-icons">settings</span>
                        </a>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        <table class="table table-bordered" id="data_table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Narratione</th>
                                    <th>Invoice Date</th>
                                    <th>Party A/C</th>
                                    <th>sale Ledger</th>
                                
                                    <th>Total</th>
                                    <th>Discount</th>
                                    <th>VAT/TAX</th>
                                    <th>Round Of</th>
                                    <th>G. Total</th>
                                    <th>Status</th>
                                    <th style="width: 185px; text-align:center">Actions</th>

                                </tr>
                            </thead>

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
        $('#data_table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "{{ route('sale.all') }}",
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                }, {
                    data: 'narration',
                    name: 'narration'
             
                }, {
                    data: 'invoice_date',
                    name: 'invoice_date'
                }, {
                    data: 'party_ac',
                    name: 'party_ac'
                }, {
                    data: 'sale_ledger',
                    name: 'sale_ledger'
                }, {
                    data: 'total',
                    name: 'total'
                }, {
                    data: 'discount',
                    name: 'discount'
                }, {
                    data: 'vat',
                    name: 'vat'
                },
                {
                    data: 'round_of',
                    name: 'round_of'
                },
                {
                    data: 'grand_total',
                    name: 'grand_total'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]

        });

     

    });
</script>
<script>

       
       function isdelete(self){
            Swal.fire({
                title: 'Are you sure?',
                text: "To confirm deletion, type delete in the text input field.",
                icon: 'warning',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    if(login == 'delete'){
                        confirmdelete(self);
                    }else{
                        alert('Not delete');
                    }
                   
                },
             
            });             

       }

        function confirmdelete(self){
            var route = $(self).data('route');
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
            {
                url: route,
                type: 'DELETE', 
                dataType: "JSON",
                data: {
                    "id": 1 
                },
                success: function (response)
                {
                    $('#data_table').DataTable().ajax.reload();
                    console.log(response);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                console.log(xhr.responseText); 
            }
            });
        }
   
   
</script>


@endpush