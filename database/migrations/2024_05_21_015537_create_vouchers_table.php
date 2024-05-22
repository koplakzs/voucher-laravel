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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('id_voucher')->unique()->primary();
            $table->string("id_user");
            $table->string("invoice")->unique();
            $table->bigInteger("exp");
            $table->boolean("used");
            $table->timestamps();


            $table->foreign("id_user")->references("uuid")->on("customers")->cascadeOnDelete();
            $table->foreign("invoice")->references("invoice")->on("transactions")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
