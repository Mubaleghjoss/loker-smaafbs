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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->string('registration_code', 40)->unique();

            $table->foreignId('position_id')->nullable()->constrained('positions')->nullOnDelete();
            $table->string('position_title', 150);

            $table->string('full_name', 150);
            $table->string('email', 190)->nullable();

            $table->string('birth_place', 120);
            $table->date('birth_date');

            $table->text('address');
            $table->string('domicile', 120);
            $table->string('whatsapp', 30);

            $table->string('last_education', 60);
            $table->string('major', 120);
            $table->string('campus', 150);

            $table->string('connected_address', 200);

            $table->unsignedInteger('expected_salary')->nullable();

            $table->string('cv_path', 500);
            $table->string('diploma_path', 500);

            $table->string('status', 30)->default('diproses');
            $table->text('public_note')->nullable();
            $table->text('internal_note')->nullable();

            $table->ipAddress('submitted_ip')->nullable();
            $table->text('submitted_user_agent')->nullable();
            $table->timestamp('submitted_at')->useCurrent();

            $table->timestamps();

            $table->index(['position_id', 'status']);
            $table->index(['submitted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
