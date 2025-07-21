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
        Schema::create('mom_responsibles', function (Blueprint $table) {
            $table->unsignedBigInteger('mom_detail_id');
            $table->unsignedBigInteger('user_id');

            $table->primary(['mom_detail_id', 'user_id']);

            $table->foreign('mom_detail_id')
                ->references('id')->on('mom_details')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_responsibles');
    }
};
