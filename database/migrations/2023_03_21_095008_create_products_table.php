<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->char('category_uuid', 36);
            $table->foreign('category_uuid')->references('uuid')->on('categories')->onDelete('cascade');
            $table->char('uuid', 36);
            $table->string('title', 255);
            $table->double('price', 12, 2);
            $table->text('description');
            $table->json('metadata');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
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
};
