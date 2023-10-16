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
        Schema::create('infos', function (Blueprint $table) {
            $table->id();

    // first slide
            $table->string('eng_name');
            $table->string('mm_name');
            $table->string('pap_name');

            $table->string('dob');
            $table->string('race');

            $table->string('driver_license');
            $table->string('home_phone');
            $table->string('mobile_phone');

            $table->string('Gender');
            $table->string('Marital_Status');
            $table->string('Passport_NO');

            $table->foreignId('nrcs_id')->constrained('nrcs')->cascadeOnDelete();
            $table->foreignId('nrcs_name')->constrained('nrcs')->cascadeOnDelete();

            $table->string('naing_id');
            $table->string('nrc_number');

            $table->string('blood_id');
            $table->string('nationality_id');
            $table->string('religion_id');
            $table->string('vacancy_id');

            $table->string('Social_Media_URL');

    // second

        // reference
            $table->boolean('reference')->default(1);
            $table->string('ref_person');
            $table->string('job_pos');
            $table->string('ref_email');
            $table->string('ref_phone');

        //family
            $table->boolean('family')->default(1);
            $table->string('family_mmname');
            $table->string('family_mmrs');
            $table->string('family_mmdob');
            $table->string('occupation');
            $table->string('family_mmphone');
            $table->string('family_mmaddress');

        // tax
            $table->boolean('tax')->default(1);
            $table->string('tax_employer');

    // three

    //     address
            $table->string('country');
            $table->string('state');
            $table->string('township');
            $table->string('st_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
