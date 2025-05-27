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
        Schema::create('mom_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mom_id')->nullable();
            $table->text('topic');
            $table->text('next_step')->nullable();
            $table->date('target_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('mom_id')
                ->references('id')->on('moms')
                ->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_details');
    }
};
