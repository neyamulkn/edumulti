<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
           $table->string('order_id', 15);
            $table->unsignedBigInteger('course_id');
            $table->integer('user_id');
            $table->integer('author_id')->nullable();
            $table->string('user_name', 75);
            $table->string('user_email', 50)->nullable();
            $table->string('user_phone', 45);
            $table->integer('total_qty');
            $table->decimal('total_price', 8,2);
            $table->string('plan')->nullable(); //monthly, quarterly, yearly, lifetime
            $table->string('notes')->nullable();
            $table->integer('affilate_user')->nullable();
            $table->decimal('affilate_amount', 8,2)->nullable();
            $table->string('currency', 6);
            $table->string('currency_sign', 3);
            $table->string('currency_value', 8)->nullable();
            $table->string('payment_method', 20)->default('pending');
            $table->string('pay_mobile_no', 55)->nullable();
            $table->string('tnx_id', 55)->nullable();
            $table->string('payment_info')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->decimal('shipping_cost')->nullable();
            $table->string('coupon_code',25)->nullable();
            $table->decimal('coupon_discount', 8,2)->nullable();
            $table->decimal('offer')->nullable();
            $table->string('payment_status', 10)->default('pending')->comment('pending,process,paid');;
            $table->string('order_status', 10)->default('pending')->comment('pending,process,complete,reject');;
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
