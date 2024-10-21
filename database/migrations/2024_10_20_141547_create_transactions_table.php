<?php

use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vmm_id')->nullable()->constrained('v_m_m_s')->onDelete('cascade');
            $table->unsignedBigInteger('amount');
            $table->enum('type', [TransactionType::getValues()])->default(TransactionType::Investment);
            $table->enum('status', [TransactionStatus::getValues()])->default(TransactionStatus::Pending);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
