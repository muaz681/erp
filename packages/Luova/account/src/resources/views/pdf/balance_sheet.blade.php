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
            /* padding: 3px 5px; */
            margin: 0;
            padding: 0;
        }

        table>tr>td>table>tr>td {
            /* border: 0px solid #000000 !important; */
        }

        .bable2,
        .bable2 th,
        .bable2 td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 14px;
        }
     
  
        .pt td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 14px;
            padding: 5px;
        }
        .thead{
            width: 50%; 
            padding:5px;
            text-align: center;
            font-weight:bold;
        }
        .tfoot{
          
            padding:5px;
            text-align: right;
            font-weight:bold;
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
  
       
    <div style="margin:0 20px 0 20px; padding:0 10px">
        <p>Date: {{date('d-M-Y')}}</p>
    </div>
    <div style="margin:0 20px 0 20px; padding:0 10px">
        
        <h2 style="text-align: center">Balance Sheet</h2>
        <table class="bable2" style="width: 100%">
       
                <tr>
                    <td class="thead" style="width:50%" colspan="2">Liabilities</td>
                    <td class="thead" style="width:50%" colspan="2">Assets</td>
                </tr>
        
                {{-- <tr> --}}
                <tr style="margin: 0">
                    {{-- <td style="padding: 0; vertical-align: top; width:100%;margin:0" colspan="2"> --}}
                    <td style="vertical-align: top;" colspan="2">
                        {{-- <table style="width: 100%; margin:0;padding: 0;"> --}}
                        <table style="width: 100%; border-top: none; border-right: none;" class="pt"> 
                            @php
                                $total_lib = 0;
                                $total_ass = 0;

                            @endphp
                        
                            @foreach($liabilities as $key => $value)
                            <tr >
                     
                                <td style="border-top:0px;border-left:0">
                                    {{ $value->title }}
                                </td>

                                <td style="border-top:0px;">
                                
                                   
                                </td>
                                <td class="text-right" style="border-top:0px;border-right:0">
                                    @if($value->ledgers)
                                    @php
                                        $total = $value->ledgers()->sum('credit') - $value->ledgers()->sum('debit');
                                        $total_lib += round($total,2);
                                    @endphp
                                    
                                    {{ money($total) }}
                                    @endif
                                   
                                </td>
                            </tr>
                            
                            @endforeach
                     
                           

                          
                      
                            @foreach($bs_pal as $key => $value)
                            <tr>
                                <td style="border-left:0">
                                    <b>{{ $value['name'] }}</b></td>
                                <td>
                                   
                                   
                                </td>
                                <td class="text-right" style="border-right:0">
                                    @php
                                                                                    
                                    $total_lib += round($value['total'],2);
                                @endphp
                                    {{ money($value['total']) }}
                                  
                                </td>
                            </tr>
                    
                            @foreach($value['data'] as $key => $list)
                         
                            <tr>
                                <td style="border-left:0"> 
                                    <i style="padding-left:15px">{{ $list['name'] }}</i>
                                </td>
                                <td class="text-right">
                                   <i> {{ money($list['amount']) }}    </i>           
                                </td>
                                <td class="text-right" style="border-right:0"> </td>
                            </tr>
                            @endforeach
                            @endforeach
                           
                           
                          
                        </table>

                    </td>
                    <td style="padding: 0" colspan="2">
                        {{-- <table class="table  table-striped table-borderless" style="width: 100%"> --}}
                        <table class="pt" style="width: 100%; border-left: hidden;
                        border-top: hidden;
                        border-right: hidden; border-bottom: hidden;">
                            @foreach($assets as $key => $value)
                            <tr >
                     
                                <td style="border-top:0px;border-left:0">
                                    {{ $value->title }}
                                </td>

                                <td style="border-top:0px;">
                                
                                   
                                </td>
                                <td class="text-right" style="border-top:0px;border-right:0">
                                    @if($value->ledgers)
                                    @php
                                        $total = $value->ledgers()->sum('credit') - $value->ledgers()->sum('debit');
                                        $total_lib += round($total,2);
                                    @endphp
                                    
                                    {{ money($total) }}
                                    @endif
                                   
                                </td>
                            </tr>
                            
                            @endforeach
                       
                          
                          
                            @foreach($bs_assets as $key => $value)
                            <tr>
                                <td style="border-left:0">
                                    <b>{{ $value['name'] }}</b>
                                </td>
                                <td>
                                   
                                   
                                </td>
                                <td class="text-right" style="border-right:0">
                                    @php
                                                                                    
                                    $total_ass += round($value['total'],2);
                                @endphp
                                    {{ money($value['total']) }}
                                  
                                </td>
                            </tr>
                    
                            @foreach($value['data'] as $key => $list)
                         
                            <tr>
                                <td style="border-left:0"
                                ><i class="bl-sub">{{ $list['name'] }}</i>
                            </td>
                                <td class="text-right">
                                   <i> {{ money($list['amount']) }}    </i>           
                                </td>
                            <td class="text-right" style="border-right:0"> </td>
                            </tr>
                            @endforeach
                            @endforeach

                          
                        </table>

                    </td>
                </tr>
                
          
                <tr>

                    <th class="tfoot">
                        Total
                     </th>
                     <th class="tfoot">
                         {{ money($total_lib) }}
                     </th>
                     <th class="tfoot">
                         Total
                     </th>
                     <th class="tfoot">
                         {{ money($total_ass) }}
                     </th>
                </tr>
         

        </table>
    </div>
    
 

    @endif
</body>

</html>