<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\FollowUpStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id',)->constrained('users',)->onDelete('cascade');
            $table->foreignId('lead_id')->constrained('leads',)->onDelete('cascade');
            $table->timestamp('scheduled_at');
            $table->enum('status', FollowUpStatusEnum::toArray())->default(FollowUpStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
