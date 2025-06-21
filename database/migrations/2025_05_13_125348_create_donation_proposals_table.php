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
        Schema::create('donation_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_profile')->constrained('profiles');
            $table->foreignId('id_donation_type')->constrained('donation_types');
            $table->string('title');
            $table->string('image_campaign');
            $table->string('image_letter');
            $table->string('letter_number')->unique();
            $table->text('story');
            $table->text('address');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_proposals');
    }
};
