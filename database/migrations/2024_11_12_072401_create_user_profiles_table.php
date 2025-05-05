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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('code_id')->constrained()->onDelete('cascade');
            // $table->string('dob')->nullable();
            $table->string('img')->nullable();
            $table->foreignId('series_id')->default(1)->constrained()->onDelete('cascade');
            $table->foreignId('standard_id')->constrained()->onDelete('cascade')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->date('trial_end')->default(now()->addWeek());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
