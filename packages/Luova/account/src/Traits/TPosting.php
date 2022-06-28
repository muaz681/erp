<?php

namespace Luova\Account\Traits;

use Illuminate\Http\Request;
use Luova\Account\Models\Account;
use Luova\Account\Models\AccountJournal;
use Luova\Account\Models\AccountLedger;
use Luova\Inventory\Models\Product;

trait TPosting
{
    public function PuerchasePosting($request,$id)
    {

        $default = [
            'remarks' => $request->get('remarks'),
            'sort_by' => $request->get('sort_by'),
            'is_active' => $request->get('is_active') ? $request->get('is_active') : 'Yes',
            'modified_by' => auth()->user()->id,
            'create_by' => auth()->user()->id,
        ];

        $jurnal_pro = [
            'voucher_type' => 'Luova\Purchase\Models\Purchase',
            'voucher_id' => $id,
            'title' => ($request->narration)?$request->narration:'Purchase Voucher',
            'narration' =>($request->narration)?$request->narration:'Purchase Voucher',
            'discription' =>($request->narration)?$request->narration:'Purchase Voucher',
            'amount' => $request->grand_total,
        ];

        $jurnal_pro_arr = array_merge($jurnal_pro, $default);

        $jurnal = AccountJournal::create($jurnal_pro_arr);

        $this->ledgerPosting($request,[
            'account_id' => $request->party_ac, 
            'journal_id' => $jurnal->id, 
            'debit' =>0.00, 
            'credit' =>$request->grand_total,
        ]);
        $this->ledgerPosting($request,[
            'account_id' => $request->purchase_ledger, 
            'journal_id' => $jurnal->id, 
            'debit' =>$request->grand_total, 
            'credit' =>0.00,
        ]);


    }
    public function SalePosting($request,$id)
    {
        $purchage_price = 0;
       foreach($request->item as $item){
           $product = Product::find($item['product']);
           if($product){
            $purchage_price +=$product->avg_purchase * $item['qty'];
           }
       }
       $profit = round($request->total - $purchage_price,2);

       $netcost = $request->total- $profit;
    
        $default = [
            'remarks' => $request->get('remarks'),
            'sort_by' => $request->get('sort_by'),
            'is_active' => $request->get('is_active') ? $request->get('is_active') : 'Yes',
            'modified_by' => auth()->user()->id,
            'create_by' => auth()->user()->id,
        ];

        $jurnal_pro = [
            'voucher_type' => 'Luova\Sale\Models\Sale',
            'voucher_id' => $id,
            'title' => ($request->narration)?$request->narration:'Sale Voucher',
            'narration' => ($request->narration)?$request->narration:'Sale Voucher',
            'discription' => ($request->narration)?$request->narration:'Sale Voucher',
            'amount' => $request->grand_total,
        ];

        $jurnal_pro_arr = array_merge($jurnal_pro, $default);

        $jurnal = AccountJournal::create($jurnal_pro_arr);

        // Party Posting 
        $this->ledgerPosting($request,[
            'account_id' => $request->party_ac, 
            'journal_id' => $jurnal->id, 
            'debit' =>$request->grand_total, 
            'credit' =>0.00,
        ]);
        // Sale Ledger
        $this->ledgerPosting($request,[
            'account_id' => $request->sale_ledger, 
            'journal_id' => $jurnal->id, 
            'debit' =>0.00, 
            'credit' => $request->grand_total,
        ]);
        // Profit & Loss A/c -> 901 |head->
        if(isset(sale_setting()->cogs) && $netcost > 0){
            $has_account = sale_setting()->cogs;
            $this->ledgerPosting($request,[
                'account_id' => $has_account, 
                'journal_id' => $jurnal->id, 
                'debit' => $netcost, 
                'credit' => 0.00,
            ]);
        }
        // Discout -> 902
        if(isset(sale_setting()->discount) && $request->discount > 0){
            $this->ledgerPosting($request,[
                'account_id' => sale_setting()->discount, 
                'journal_id' => $jurnal->id, 
                'debit' => $request->discount, 
                'credit' => 0.00,
            ]);
        }
        // Vat and Tax -> 903
        if(isset(sale_setting()->tax_vax) && $request->vat > 0){
            $this->ledgerPosting($request,[
                'account_id' => sale_setting()->tax_vax, 
                'journal_id' => $jurnal->id, 
                'debit' =>0.00, 
                'credit' =>$request->vat,
            ]);
        }
        // Rount OF -> 904
        if(isset(sale_setting()->round_of) && $request->round_of <> 0){
            
            $this->ledgerPosting($request,[
                'account_id' => sale_setting()->round_of, 
                'journal_id' => $jurnal->id, 
                'debit' => ($request->round_of < 0)? ($request->round_of * -1) : 0.00, 
                'credit' => ($request->round_of > 0)? $request->round_of : 0.00,
            ]);
        }

  


    }
    public function ReceiptPosting($request,$id)
    {
       
        $default = [
            'remarks' => $request->get('remarks'),
            'sort_by' => $request->get('sort_by'),
            'is_active' => 'Yes',
            'modified_by' => auth()->user()->id,
            'create_by' => auth()->user()->id,
        ];

        $jurnal_pro = [
            'voucher_type' => 'Luova\Receipt\Models\Receipt',
            'voucher_id' => $id,
            'title' => ($request->narration)?$request->narration:'Receipt Voucher',
            'narration' => ($request->narration)?$request->narration:'Receipt Voucher',
            'discription' => ($request->narration)?$request->narration:'Receipt Voucher',
            'amount' => $request->total_debit,
        ];


        $jurnal_pro_arr = array_merge($jurnal_pro, $default);

        $jurnal = AccountJournal::create($jurnal_pro_arr);

        foreach($request->item as $list){
               $this->ledgerPosting($request,[
                'account_id' =>$list['account'], 
                'journal_id' => $jurnal->id, 
                'debit' => $list['debit'], 
                'credit' => $list['credit'],
            ]);
           }

    }
    public function PaymentPosting($request,$id)
    {
       
        $default = [
            'remarks' => $request->get('remarks'),
            'sort_by' => $request->get('sort_by'),
            'is_active' => 'Yes',
            'modified_by' => auth()->user()->id,
            'create_by' => auth()->user()->id,
        ];

        $jurnal_pro = [
            'voucher_type' => 'Luova\Payment\Models\Payment',
            'voucher_id' => $id,
            'title' => ($request->narration)?$request->narration:'Payment Voucher',
            'narration' => ($request->narration)?$request->narration:'Payment Voucher',
            'discription' => ($request->narration)?$request->narration:'Payment Voucher',
            'amount' => $request->total_debit,
        ];


        $jurnal_pro_arr = array_merge($jurnal_pro, $default);

        $jurnal = AccountJournal::create($jurnal_pro_arr);

        foreach($request->item as $list){
               $this->ledgerPosting($request,[
                'account_id' =>$list['account'], 
                'journal_id' => $jurnal->id, 
                'debit' => $list['debit'], 
                'credit' => $list['credit'],
            ]);
           }

    }
    


    public function ledgerPosting($request, $data)
    {

        $default = [
            'remarks' => $request->get('remarks'),
            'sort_by' => $request->get('sort_by'),
            'is_active' => 'Yes',
            'modified_by' => auth()->user()->id,
            'create_by' => auth()->user()->id,
        ];
   
        $ledger_pro_arr = array_merge($data, $default);
        //dd($ledger_pro_arr);
        AccountLedger::create($ledger_pro_arr);
    }
    private function HasAccount($id,$code, $head, $name){
        $account = Account::find($id);
        if($account){
            return $account->id;
        }else{
         
            $account = Account::create([
                    'id' => $id,
                    'title' => $name,
                    'ac_head' => $head,
                    'parent_id' => null,
                    'user_id' => null,
                    'code' => $code,
                    'remarks' => null,
                    'sort_by' => null,
                    'is_active' => 'Yes',
                    'modified_by' => auth()->user()->id,
                    'create_by' => auth()->user()->id,
                ]);
            return $account->id;
        }
    }
}
