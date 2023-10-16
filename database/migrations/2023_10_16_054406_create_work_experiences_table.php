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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->boolean('work')->default(0);
            $table->string('job_title');
            $table->string('company_name');
            $table->string('work_from');
            $table->string('work_to');
            $table->string('work_contact');
            $table->string('work_address');
            $table->string('attachment');
            $table->foreignId('info_id')->constrained('infos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
