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
        Schema::create('exam_paper_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('lecturer_full_name');
            $table->enum('submission_type', ['degree', 'diploma']); // To distinguish the type

            // Degree specific (nullable)
            $table->string('degree_name')->nullable();
            $table->string('degree_batch')->nullable();
            $table->string('degree_subject_and_code')->nullable();

            // Diploma specific (nullable)
            $table->string('diploma_name')->nullable();
            $table->string('diploma_subject_code')->nullable();
            $table->string('diploma_batch')->nullable();
            
            $table->date('exam_date');
            $table->string('file_path'); // Path to the uploaded paper in storage
            $table->string('original_filename'); // Original name of the uploaded file
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('file_size')->nullable(); // Size in bytes
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_paper_submissions');
    }
};
