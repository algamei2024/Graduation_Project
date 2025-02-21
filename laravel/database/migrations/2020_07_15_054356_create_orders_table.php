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

            // to delete
            $table->string('order_number')->unique();


            $table->unsignedBigInteger('user_id')->nullable();
             // to delete
            $table->float('sub_total');
            // to delete
            $table->unsignedBigInteger('shipping_id')->nullable();

            
            $table->float('coupon')->nullable();

            $table->float('total_amount');
            // to delete
            $table->integer('quantity');

            $table->enum('payment_method',['cod','paypal'])->default('cod');

            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->enum('status',['new','process','delivered','cancel'])->default('new');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');


            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('SET NULL');
            // all this to delete 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('country'); 
            $table->text('address1');
            $table->text('address2')->nullable();
            // end for delete comment
            $table->string('post_code')->nullable();
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