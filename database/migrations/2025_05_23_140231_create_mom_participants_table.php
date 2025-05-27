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
        Schema::create('mom_participants', function (Blueprint $table) {
            $table->unsignedBigInteger('mom_id');
            $table->unsignedBigInteger('user_id');

            $table->primary(['user_id', 'mom_id']);

            $table->foreign('mom_id')
                ->references('id')->on('moms')
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
        Schema::dropIfExists('mom_participants');
    }
};
