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
        Schema::create('mom_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mom_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('mom_id')
                ->references('id')->on('moms')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_approvals');
    }
};
