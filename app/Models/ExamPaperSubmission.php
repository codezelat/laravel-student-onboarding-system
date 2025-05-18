<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamPaperSubmission extends Model
{
    protected $fillable = [
        'lecturer_full_name',
        'submission_type',
        'degree_name',
        'degree_batch',
        'degree_subject_and_code',
        'diploma_name',
        'diploma_subject_code',
        'diploma_batch',
        'exam_date',
        'file_path',
        'original_filename',
        'mime_type',
        'file_size',
    ];
}
