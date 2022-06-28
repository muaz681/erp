<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalCustomerUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->boolean('is_local')->default(0)->nullable()->after('invoice_date');
            $table->unsignedBigInteger('customer_id')->nullable()->after('is_local');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete ('cascade');
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['is_local', 'customer_id']);
        });
    }
}
