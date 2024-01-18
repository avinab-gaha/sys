<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->string('name')->nullable();
            $table->float('price')->nullable();
            $table->string('detail')->nullable();
            $table->string('image')->nullable();
            $table->string('imgpath')->nullable();
            $table->timestamps();
        });

        // if (Schema::hasTable('flights')) {
        //     //the 'users' table exists
        // }

        // if (Schema::hasColumn('flights', 'id')) {
        //     //the 'users' table exits and has 'id' column
        // }

        // Schema::table('flights', function (Blueprint $table) {
        //     $table->integer('id')->nullable;
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
