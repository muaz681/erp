@extends('layouts.master')
@section('title',  ' Sales Setting ')
@section('content')


@php
$selectAccount =AccountSelectType('Expense');
$rn = 0;
if(Session::has('myexcep')){
    dump(Session::get('myexcep'));
}
@endphp

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        {{ Form::open(['method' => 'POST', 'route'=>'sale.setting.store']) }}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                          

                            @isset(sale_setting()->cogs)
                            <a href="{{route('sale.add')}}" class="btn btn-sm btn-success">
                                <span class="material-icons">add_circle_outline</span> New sales
                            </a>
                            <a href="{{route('sale.local')}}" class="btn btn-sm btn-danger">
                                <span class="material-icons">add_circle_outline</span> Local sale
                            </a>
                            @endisset
                          
                            
                        </h3>
                    </div>
                    <!-- @dump($fdata) -->
                    <!-- /.card-header -->
                    <!-- form start -->

                    <div class="card-body">

                        <div class="row" id="RecieptHead">
                            <div class="col-md-12 ">
                                <div class="form-group row">

                                  
                                    {{ Form::label('cogs', 'Cost of Goods Sale AC',['class' => 'col-sm-2 col-form-label'])}}
                                    <div class="col-sm-4">
                                        {{ Form::select('cogs', $selectAccount,(!empty($fdata->cogs) ? $fdata->cogs : NULL), ['class' => (($errors->has('cogs')? 'is-invalid': ''). ' form-control select2'), 'placeholder' => 'Select' ]) }}
                                        @error('cogs')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
            
                                    </div>

                                </div>
                                <div class="form-group row">
                                    {{ Form::label('shipping_fee', 'Shipping fee AC',['class' => 'col-sm-2 col-form-label'])}}
                                    <div class="col-sm-4">
                                        {{ Form::select('shipping_fee', $selectAccount,(!empty($fdata->shipping_fee) ? $fdata->shipping_fee : NULL), ['class' => (($errors->has('shipping_fee')? 'is-invalid': ''). ' form-control select2'), 'placeholder' => 'Select' ]) }}
                                        @error('shipping_fee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('discount', 'Discount AC',['class' => 'col-sm-2 col-form-label'])}}
                                    <div class="col-sm-4">
                                        {{ Form::select('discount', $selectAccount,(!empty($fdata->discount) ? $fdata->discount : NULL), ['class' => (($errors->has('discount')? 'is-invalid': ''). ' form-control select2'), 'placeholder' => 'Select' ]) }}
                                        @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    {{ Form::label('round_of', 'Round Of AC',['class' => 'col-sm-2 col-form-label'])}}
                                    <div class="col-sm-4">
                                        {{ Form::select('round_of', $selectAccount,(!empty($fdata->round_of) ? $fdata->round_of : NULL), ['class' => (($errors->has('round_of')? 'is-invalid': ''). ' form-control select2'), 'placeholder' => 'Select' ]) }}
                                        @error('round_of')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('tax_vax', 'Tax & Vax AC',['class' => 'col-sm-2 col-form-label'])}}
                                    <div class="col-sm-4">
                                        {{ Form::select('tax_vax', $selectAccount,(!empty($fdata->tax_vax) ? $fdata->tax_vax : NULL), ['class' => (($errors->has('tax_vax')? 'is-invalid': ''). ' form-control select2'), 'placeholder' => 'Select' ]) }}
                                        @error('tax_vax')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
  

                                
                                
                            </div>

                           
                        </div>

                     



                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-success btn-lg  ">{{ __('Submit') }}</button>
                    </div>

                </div>
            </div>



        </div>
        {{ Form::close() }}


        <!-- /.row -->

    </div><!-- /.container-fluid -->
</section>



<!-- ./wrapper -->
@endsection




@push('scripts')


@endpush

@push('headcss')



@endpush