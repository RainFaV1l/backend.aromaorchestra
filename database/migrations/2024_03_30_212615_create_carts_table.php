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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->foreignId('status_id')->default(1)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('delivery_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('address', 2000);
            $table->unsignedFloat('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
