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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('people_id')->nullable();
            $table->date('transaction_date');
            $table->string('unique_code')->nullable($value = true);
            $table->integer('base_price')->nullable($value = true);
            $table->integer('price')->nullable($value = true);
            $table->integer('quantity');
            $table->integer('discount')->nullable($value = true);
            $table->integer('cost')->nullable($value = true);
            $table->integer('charge')->nullable($value = true);
            $table->mediumText('remark')->nullable($value = true);
            $table->integer('transaction_status');
            $table->enum('transaction_type', ['in', 'out']);
            $table->integer('paid')->default(0);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable($value = true);
            $table->timestamps();
            $table->softDeletes();
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
