<?php

namespace App\database\migrations;

use Illuminate\framework\Blueprint;
use Illuminate\framework\factory\Schema;
use Illuminate\framework\interface\Migration;

class Product implements Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('price');
            $table->string('qty');
            $table->integer('product_category_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('product_category_id', 'product_category');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
}
