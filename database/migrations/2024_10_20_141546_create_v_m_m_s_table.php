<?php

use App\Enums\VMMStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('v_m_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('lifetime');
            $table->unsignedInteger('minimum_invest');
            $table->unsignedInteger('distribute_coin');
            $table->unsignedInteger('execution_time');
            $table->unsignedInteger('preparation_time');
            $table->dateTime('start_time');
            $table->enum('type', [VMMStatus::getValues()])->default(VMMStatus::Draft);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_m_m_s');
    }
};
