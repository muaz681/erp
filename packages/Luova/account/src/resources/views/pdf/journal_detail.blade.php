<!DOCTYPE html>
<html>

<head>
 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title> Journal Details </title>
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
            margin-bottom: 50px;
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
            <tr style="background:#ADD3CA">

                <td style="text-align: center;width:100%">
                    https://theleatherart.com
                </td>
        
            </tr>


        </table>
    </htmlpagefooter>
  
       

    <div style="margin:20px; padding: 30px">
        <table class="" style="width: 100%">
   
                <tbody>
                    <tr>
                        <td style="width: 30%; text-align: left">
                            Voucher Date 
                        </td>
                        <td style="width: 70%; text-align: left">
                           : {{ ($mdata->created_at)? date('d-M-Y', strtotime($mdata->created_at)):null }}
                        </td>
                      
                    </tr>
                    <tr>
                        <td style="width: 30%; text-align: left">
                            Voucher No 
                        </td>
                        <td style="width: 70%; text-align: left">
                           : {{ ($mdata->narration)? $mdata->narration:null }}
                        </td>
                      
                    </tr>
                    <tr>
                        <td style="width: 30%; text-align: left">
                            Narration
                        </td>
                        <td style="width: 70%; text-align: left">
                           :  {{ ($mdata->id)? $mdata->id:null }}
                        </td>
                      
                    </tr>
                  
                </tbody>
        </table>
        <br>

        <table class="bable2" style="width: 100%">
   
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Account</th>
                        <th>Account Head</th>
                        <th>Debit</th>
                        <th>Credit </th>                                 
                    
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
                  

                    </tr>
                </tfoot>

            </table>
    </div>
    
 

    @endif
</body>

</html>