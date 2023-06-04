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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('ticket_status_id')->references('id')->on('ticket_statuses')->cascadeOnDelete();
            $table->foreignId('ticket_category_id')->references('id')->on('ticket_categories')->cascadeOnDelete();
            $table->foreignId('ticket_department_id')->references('id')->on('roles')->cascadeOnDelete();
            $table->string('title');
            $table->longText('message')->nullable();
            $table->tinyInteger('priority')->comment('0-low, 1-mid, 2-high');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
