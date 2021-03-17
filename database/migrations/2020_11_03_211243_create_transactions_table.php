<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type', 25)->comment('order, withdraw, wallet, refund, blTransfer');
            $table->string('notes')->nullable();
            $table->string('payment_method', 25)->nullable();
            $table->string('transaction_details', 25)->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('from_user_id')->nullable();
            $table->string('item_id', 15)->nullable();
            $table->double('amount', 8, 2);
            $table->double('total_amount', 8, 2)->nullable();
            $table->double('commission', 8, 2)->default(0);
            $table->string('ref_id', 25)->nullable();
            $table->double('ref_earning', 8, 2)->nullable();
            $table->integer('created_by')->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
