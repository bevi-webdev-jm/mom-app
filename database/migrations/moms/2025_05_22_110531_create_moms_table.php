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
        Schema::create('moms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mom_type_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('mom_number');
            $table->text('agenda')->nullable();
            $table->text('remarks')->nullable();
            $table->date('meeting_date');
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('mom_type_id')
                ->references('id')->on('mom_types')
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
        Schema::dropIfExists('moms');
    }
};
