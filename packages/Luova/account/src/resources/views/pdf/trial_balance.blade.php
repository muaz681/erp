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
        <table class="bable2" style="width: 100%">
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
                        {{ $list->title }}
                    
                    </td>
                    <td style="text-align: right">{{ money($list->debit_sum) }}</td>
                    <td style="text-align: right">{{ money($list->credit_sum) }}</td>
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
                
                    <th style="text-align: right">{{ money($total_debit) }}</th>
                    <th style="text-align: right">{{ money($total_credit) }}</th>

                </tr>
            </tfoot>
        </table>
    </div>
    
 

    @endif
</body>

</html>