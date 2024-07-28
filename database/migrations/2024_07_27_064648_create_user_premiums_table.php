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
        Schema::create('user_premiums', function (Blueprint $table) {
            $table->id();
            $table->uuid('device_uuid');
            $table->uuid('product_id');
            $table->smallInteger('remaining_chat_credit')->unsigned();
            $table->longText('receipt_token');
            $table->boolean('is_active');
            $table->timestamps();

            $table->foreign('device_uuid')->references('uuid')->on('devices');
            $table->foreign('product_id')->references('uuid')->on('products');

            $table->index(['device_uuid', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_premiums');
    }
};
