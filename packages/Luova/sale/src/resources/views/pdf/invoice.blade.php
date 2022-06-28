<!DOCTYPE html>
<html>

<head>
 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title> Invoice </title>
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            font-size: 17px;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            padding: 3px 5px;
        }

        table>tr>td>table>tr>td {
            /* border: 0px solid #000000 !important; */
        }

        .bable2,
        .bable2 th,
        .bable2 td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 130px;
            margin-bottom: 160px;
        }
    </style>
</head>

<body>

    <?php
//dd($settings);
?>

    @if (Route::has('login'))

    <htmlpageheader name="page-header">
        <div style="width:100%; padding:15px 30px 5px; border-bottom: 5px solid #000;">
            <table style="width:100%;margin:auto;  ">
    
                <tr>
                    <td style="width:50%; ">
                        <img src="{{ asset('images/logo.png') }}" style="height:80px; margin:5px ">
                    </td>
                    <td style="width:50%; text-align:right;">
                        
                        <p style="font-size:14px">
                            10, East Kazipara, Dhaka 1216.<br>
                            Contact : +8801789760061<br>
                            E-mail : leatherart2022@gmail.com<br>
                            Websit: https://theleatherart.com<br>
                        </p>
                    </td>
    
    
                </tr>
            </table>
        </div>
     
   
    </htmlpageheader>
    <htmlpagefooter name="page-footer">
        <table border="0" style="width:100%;margin:auto;">
            <tr>
                <td style="width: 10%">
                    
                </td>
                <td style="width: 35%;text-align: center; border-top:2px solid #000">
                    Received By
                </td>
                <td style="width: 10%">
                    
                </td>
                <td style="width: 35%;text-align: center; border-top:2px solid #000">
                    Authorized by
                </td>
                <td style="width: 10%">
                    
                </td>
        
            </tr>


        </table>
        <br>
        <br>
        <table border="0" style="width:100%;margin:auto;">
            <tr style="background:#ADD3CA">

                <td style="text-align: center;width:100%">
                    https://theleatherart.com
                </td>
        
            </tr>


        </table>
    </htmlpagefooter>
        @foreach ($copies as $k => $copy)
        @if($k !=0)
        <div style="page-break-before: always;"></div>
        @endif
       

    <div style="margin:20px; padding: 30px">

        <h2 style="text-align: center">Invoice</h2>
        {{-- Shipping address  --}}
        {{-- @dump($data->details) --}}
        <table style="width: 100%">
            <tr>
                <td style="width: 50%">
                    <table style="width: 100%; border: 1px solid #000">
                        <tr>
                            <td colspan="2" style="width: 100%; background:#000;color:#fff; text-align:left">
                                Shipping Address
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="width: 30%">
                                Name
                            </td>
                            <td style="width: 70%">
                                @isset($data->customer->name)
                                    : {{ $data->customer->name }}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phone
                            </td>
                            <td>
                                @isset($data->customer->phone)
                                : {{ $data->customer->phone }}
                            @endisset
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Address
                            </td>
                            <td>
                                @isset($data->customer->address)
                               : {{ $data->customer->address }}
                            @endisset
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 100%; text-align:right">
                          
                                {{-- @dump($data) --}}
                                <b>Invoice Number :</b> {{ date('ymd', strtotime($data->created_at)) }}00{{ $data->id }}
                            </td>
                        </tr>
                        <tr>
                      
                            <td style="width: 100%;text-align:right">
                                <b>Order Date :</b>  {{ date('d-M-Y', strtotime($data->created_at)) }}
                            </td>
                            
                        </tr>
                        <tr>
                      
                           
                            <td style="width: 100%;text-align:right;">
                                <b>{{$copy}}</b>  
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Oder details --}}
        <h2 style="text-align: left">Order Details</h2>
        <table style="width:100%" class="bable2">
            <tr>
              <th>SL</th>
              <th style="text-align: left">Item's Detils</th> 
              <th>Price</th>
              <th>Quantity</th>
              <th>Total Price</th>
            </tr>
            @foreach ($data->details as $key =>  $list)
            <tr>
                <td style="text-align: center">{{$key +1 }}</td>
                <td style="text-align: left">
                    @isset($list->product)
                    Name:  {{$list->product->title}}<br>
                    Code:  {{$list->product->code}}, Size: 
                     
                    @endisset
                  
                </td> 
               
                <td>{{ money($list->rate) }}</td>
                <td style="text-align: center">{{$list->qty }}</td>
                <td>{{ money($list->total) }}</td>
               
              </tr>
            @endforeach

            <tr>
                <td colspan="4" style="text-align: right"> Total</td>            
                <td>{{ money($data->total) }}</td>
            </tr>
            <tr>
                <td colspan="4"  style="text-align: right">Shipping Fee</td>            
                <td>{{ money($data->shipping_fee) }}</td>
            </tr>
            <tr>
                <td colspan="4"  style="text-align: right">Discount</td>            
                <td>{{ money($data->discount) }}</td>
            </tr>
            <tr>
                <td colspan="4"  style="text-align: right"><b>Grant Total</b></td>            
                <td><b>{{ money($data->grand_total) }}</b></td>
            </tr>
          
         
          </table>
    </div>
    
    @endforeach

    @endif
</body>

</html>