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
        Schema::create('mom_action_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mom_action_id')->nullable();
            $table->text('path')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('mom_action_id')
                ->references('id')->on('mom_actions')
                ->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_action_attachments');
    }
};
