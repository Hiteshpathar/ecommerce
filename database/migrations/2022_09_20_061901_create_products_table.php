<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->integer('inventory')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->decimal('price',9,3);
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('SET NULL');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
