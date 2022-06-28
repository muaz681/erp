<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Luova\Account\Http\Controllers';

Route::namespace($namespace)->prefix('admin')->name('account.')->middleware(['web', 'auth'])->group(function () {
    Route::get('accounts', 'AccountController@index')->name('all');
    Route::get('account/journal', 'AccountController@journal')->name('journal');
    Route::get('account/ledger', 'AccountController@ledger')->name('ledger');
    Route::get('account/{id}/ledger', 'AccountController@account_ledger')->name('ledger.individual');

    Route::get('account/journal/{id}/detail', 'AccountController@journal_detail')->name('journal.detail');
    Route::get('account/add', 'AccountController@add')->name('add');
    Route::get('account/{id}/edit', 'AccountController@edit')->name('edit');
    Route::post('account/save', 'AccountController@store')->name('store');

    Route::get('account/balance-sheet', 'AccountController@balance_sheet')->name('balance.sheet');
    Route::get('account/trial-balance', 'AccountController@trial_balance')->name('trial.balance');
    Route::get('account/trial-balance/{id}/reference', 'AccountController@trial_balance_reference')->name('trial.balance.reference');
});


// Route::get('account', function () {
//     return " wow your model working";
// });
