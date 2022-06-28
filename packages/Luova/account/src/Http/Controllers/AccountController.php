<?php

namespace Luova\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Luova\Account\Http\Requests\AccountFV;
use Luova\Account\Models\Account;
use Luova\Account\Models\AccountHead;
use Luova\Account\Models\AccountJournal;
use Luova\Account\Models\AccountLedger;

use PDF;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Account::latest()->get();
            return DataTables::of($data)
                ->addColumn('title', function ($data) {
                   return '<a href="'.route('account.ledger.individual',$data->id).'">'.$data->title.'</a>';
                })
                ->addColumn('head', function ($data) {
                   return '<a href="'.route('account.trial.balance.reference',$data->head->id).'">'.$data->head->title.'</a>';
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active == 'Yes') {
                        return '<button type="button" class="edit btn btn-success btn-sm">Active</button>';
                    } else {
                        return '<button type="button" class="edit btn btn-danger btn-sm">Inactive</button>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="btn-group btn-group-sm">';
                    $button .= '<button type="button" class="btn btn-secondary btn-flat"><i class="material-icons">info</i></button>';
                    $button .= '<a href="' . route('account.edit', $data->id) . '" class="btn btn-warning btn-flat"><i class="material-icons">create</i></a>';
                    $button .= '<button type="button" class="btn btn-danger btn-flat"><i class="material-icons">delete_forever</i></button>';
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['title','head', 'status', 'action'])
                ->make(true);
        }
        $fdata = null;
        $mdata = null;
        return view('account::chart_of_accounts', compact('mdata', 'fdata'));
    }
    public function journal(Request $request)
    {
 
   
        if ($request->ajax()) {
            $data = AccountJournal::latest()->get();
            return DataTables::of($data)
                ->addColumn('voucher_type', function ($data) {
                        return ($data->voucher_type)?class_basename($data->voucher_type):null;
                })
             
                ->addColumn('amount', function ($data) {
                        return money($data->amount);
                })
           
                ->addColumn('invoice_date', function ($data) {
                        return ($data->invoice_date)?date('d-M-Y',strtotime($data->invoice_date)): null;
                })
                ->addColumn('created_at', function ($data) {
                        return ($data->created_at)?date('d-M-Y H:i a',strtotime($data->created_at)): null;
                })
                ->addColumn('receipt_ledger', function ($data) {
                        return ($data->ledger)?$data->ledger->title.' ['.$data->ledger->code.']': null;
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active == 'Yes') {
                        return '<button type="button" class="edit btn btn-success btn-sm">Active</button>';
                    } else {
                        return '<button type="button" class="edit btn btn-danger btn-sm">Inactive</button>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="btn-group btn-group-sm">';
                    $button .= '<button type="button" class="btn btn-secondary btn-flat"><i class="material-icons">info</i></button>';
                    $button .= '<a href="' . route('account.journal.detail', $data->id) . '" class="btn btn-success btn-flat"><i class="material-icons">visibility</i></a>';
                    $button .= '<button type="button" class="btn btn-danger btn-flat"><i class="material-icons">delete_forever</i></button>';
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['role', 'status', 'action'])
                ->make(true);
        }
        $fdata = null;
        $mdata = null;
        return view('account::journal', compact('mdata', 'fdata'));
    }
    public function account_ledger(Request $request,$id)
    {
 
   
        $mdata = Account::findOrFail($id);
        $fdata = null;
        return view('account::account_ledger', compact('mdata', 'fdata'));
    }

    public function ledger(Request $request)
    {
 
   
        if ($request->ajax()) {
            $data = AccountLedger::latest()->get();
            return DataTables::of($data)

                ->addColumn('account', function ($data) {
                        return  $data->account->title . ' ['. $data->account->code.']' ;
                })
                ->addColumn('account_head', function ($data) {
                        return  $data->account->head->title;
                })
             
                ->addColumn('debit', function ($data) {
                        return money($data->debit);
                })
                ->addColumn('credit', function ($data) {
                        return money($data->credit);
                })
                ->addColumn('created_at', function ($data) {
                        return ($data->created_at)?date('d-M-Y H:i a',strtotime($data->created_at)): null;
                })
        
                ->rawColumns(['role', 'status', 'action'])
                ->make(true);
        }
        $fdata = null;
        $mdata = null;
        return view('account::ledger', compact('mdata', 'fdata'));
    }
   
   
    public function journal_detail(Request $request, $id)
    {
   

        $fdata = null;
        $mdata = AccountJournal::findOrFail($id);

        if($request->type =="print"){


            $data = [
                'mdata' => $mdata,
                'setting' => null
            ];
            $config = [
                'format' => 'A4',
                'margin_header' => 0,
                'margin_footer' => 0,
                'margin_left' => 0,
                'margin_right' => 0
            ];
            ini_set("pcre.backtrack_limit", "10000000000000");

            $pdf = PDF::loadView('account::pdf.journal_detail', $data, [], $config);
            return $pdf->stream('journal_detail' . '.pdf');

        }else{

            return view('account::journal_detail', compact('mdata', 'fdata'));
        }

    }
    public function balance_sheet(Request $request)
    {
      
        $stock = $this->bs_stock();
        $profit_los = $this->bs_profit_los();
       
    //   dd($stock);
        $expense = AccountHead::where('type','Expense')->get();
      
        $assets = AccountHead::where('type','Asset')->get();
        $closing_stock = ClosingStock();
        
        $bs_assets = [
            [
                'name' => 'Current Assets',
                'data' => [
                    [
                        'name' => 'Closing Stock',
                        'amount' =>$stock
                    ]
                ],
                 'total' => $stock
            ]

        ];
        $bs_pal = [
            [
                'name' => 'Profit & Loss A/c',
                'data' => [
                    [
                        'name' => 'Current Period',
                        'amount' =>$profit_los
                    ]
                ],
                'total' => $profit_los
            ]

        ];
      
        //dd($assets->ledgers()->sum('debit'));
        $liabilities = AccountHead::where('type','Liability')->get();

        if($request->type =="print"){


            $data = [
                'expenses' => $expense,
                'bs_pal' => $bs_pal,
                'assets' => $assets,
                'liabilities' => $liabilities,
                'bs_assets' =>$bs_assets,
                'setting' => null
            ];
            $config = [
                'format' => 'A4',
                'margin_header' => 0,
                'margin_footer' => 0,
                'margin_left' => 0,
                'margin_right' => 0
            ];
            ini_set("pcre.backtrack_limit", "10000000000000");

            // return view('account::pdf.balance_sheet', $data, [], $config);
            $pdf = PDF::loadView('account::pdf.balance_sheet', $data, [], $config);
            return $pdf->stream('balance_sheet' . '.pdf');

        }else{
            return view('account::balance_sheet')->with([
                'expenses' => $expense,
                'bs_pal' => $bs_pal,
                'assets' => $assets,
                'liabilities' => $liabilities,
                'bs_assets' =>$bs_assets
            ]);
        }

    

    }

    public function add(Request $request)
    {
        $fdata =  null;
        $mdata = null;
        return view('account::add', compact('mdata', 'fdata'));
    }
    public function edit(Request $request, $id)
    {
        $fdata =  Account::findOrFail($id);
       
        return view('account::add', compact( 'fdata'));
    }
    public function store(AccountFV $request)
    {

        $head =$request->ac_head;
        if($request->parent_id){
            $head = Account::fine($request->parent_id)->ac_head;
        }
        $id = $request->get('id');
        // store
        $attributes = [
            'title' => $request->title,
            'ac_head' => $head,
            'parent_id' => $request->parent_id,
            'user_id' => $request->user_id,
            'code' => $request->code,
            'remarks' => $request->remarks,
            'sort_by' => $request->sort_by,
            'is_active' => $request->is_active ? $request->is_active : 'No',
            'modified_by' => auth()->user()->id,
        ];

        if (!$id) {
            $attributes['create_by']  = auth()->user()->id;
        }

        try {
            if ($id) {
                $existing = Account::findOrFail($id);
                $data =  Account::where('id', $id)->update($attributes);
            } else {
                Account::create($attributes);
            }
            return redirect()->route('account.all')->with('success', 'Successfully save changed');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }


    public function trial_balance_reference(Request $request,$id){
        
        
        $fdata = null;
        $mdata = AccountHead::with('accounts')->find($id);
      

       
        return view('account::trial_balance_reference', compact('mdata', 'fdata'));
    }
  
    
    public function trial_balance(Request $request){
        
        
        $fdata = null;
        $mdata = AccountHead::select(
                'account_heads.*',
                DB::raw('sum(account_ledgers.debit) as debit_sum'),
                DB::raw('sum(account_ledgers.credit) as credit_sum')
                )
            ->leftJoin('accounts', 'accounts.ac_head', '=', 'account_heads.id')
            ->leftJoin('account_ledgers', 'account_ledgers.account_id', '=', 'accounts.id')
            ->groupBy('account_heads.id')
            ->orderBy('debit_sum', 'DESC')
            ->orderBy('credit_sum', 'DESC')

        ->get();

        if($request->type =="print"){


            $data = [
                'mdata' => $mdata,
                'setting' => null
            ];
            $config = [
                'format' => 'A4',
                'margin_header' => 0,
                'margin_footer' => 0,
                'margin_left' => 0,
                'margin_right' => 0
            ];
            ini_set("pcre.backtrack_limit", "10000000000000");

            $pdf = PDF::loadView('account::pdf.trial_balance', $data, [], $config);
            return $pdf->stream('trial_balance' . '.pdf');

        }else{

            return view('account::trial_balance', compact('mdata', 'fdata'));
        }
        // dd($mdata);
    }
    public function bs_stock(){
        $purchase_head = AccountHead::find(1); //Purchase Account
        $purchase_dr = $purchase_head->ledgers()->sum('debit');
        $purchase_cr = $purchase_head->ledgers()->sum('credit');
        $total_purchase =  $purchase_dr - $purchase_cr;
        $cogs = 0;
        if(isset(sale_setting()->cogs)){

            $cogs = Account::find(sale_setting()->cogs)->ledgers()->sum('debit');
        }
        return $total_purchase - $cogs;
       
    }

    public function bs_profit_los(){

        $total_sale = AccountHead::find(2)->ledgers()->sum('credit'); //Sales Accounts
  
        $expenses = AccountHead::whereIn('id',[4,5])->get(); //Expanse Accounts
        $total_expense = 0;
        foreach($expenses as $expense){
            $dr = $expense->ledgers()->sum('debit');
            $cr = $expense->ledgers()->sum('credit');
            $total_expense +=  $dr - $cr;
        }
  

        return $total_sale - $total_expense;
    }
}
