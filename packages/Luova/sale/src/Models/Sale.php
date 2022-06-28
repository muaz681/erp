<?php


namespace Luova\Sale\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Luova\Account\Models\AccountJournal;
use Luova\Account\Models\Account;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Sale extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;
    protected $softCascade = ['details','journal'];
    protected $table = 'sales';
    protected $fillable = [
        'invoice_date', 'party_ac', 'sale_ledger', 'narration','price_type',
        'total', 'discount', 'vat', 'round_of', 'grand_total','is_local','customer_id','shipping_fee',
        'remarks', 'sort_by', 'is_active', 'create_by', 'modified_by'
    ];




    public function party()
    {
        return $this->belongsTo(Account::class, 'party_ac');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function ledger()
    {
        return $this->belongsTo(Account::class, 'sale_ledger');
    }
    public function journal()
    {
        return $this->hasOne(AccountJournal::class, 'voucher_id','id')
        ->where('voucher_type','Luova\Sale\Models\Sale');
  
    }
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

}
