<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /** @use HasFactory<\Database\Factories\AttachementFactory> */
    use HasFactory;

    protected $table = 'attachment_files';

    protected $fillable = [
        'file_name',
        'uploaded_by',
        'file_path',
        'file_size',
        'file_type'
    ];
}
