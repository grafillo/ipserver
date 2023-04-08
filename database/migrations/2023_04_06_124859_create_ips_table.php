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
        Schema::create('ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->unsignedBigInteger('web_id');
            $table->string('status')->default('free');
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('web_id')->references('id')->on('webs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ips');
    }
};
