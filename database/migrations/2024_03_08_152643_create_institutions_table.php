<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('instituteName',200)->unique();
            $table->string('govtCode',200)->unique();
            $table->string('appCode',200)->unique();
            $table->integer('contactNo')->unique();
            $table->string('address',500);
            $table->string('zilla',100);
            $table->string('dividion',100);
            $table->integer('user_id');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
