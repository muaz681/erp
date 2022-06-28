<?php

namespace Luova\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class AccountJournal extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;
    protected $softCascade = ['ledgers'];
    protected $table = 'account_journals';
    protected $fillable = [
        'voucher_type', 'voucher_id', 'title', 'narration', 'discription', 'amount','invoice_date',
        'remarks', 'sort_by', 'is_active', 'create_by', 'modified_by'
    ];

    public function ledgers()
    {
        return $this->hasMany(AccountLedger::class,'journal_id','id');
    }
}

