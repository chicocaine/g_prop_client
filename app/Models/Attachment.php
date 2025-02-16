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

    public function commissions()
    {
        return $this->belongsToMany(Commission::class, 'commission_attachment', 'attachment_id', 'commission_id')->withTimestamps();
    }

    public function message()
    {
        return $this->belongsToMany(Message::class, 'message_attachment', 'attachment_id', 'message_id')->withTimestamps();
    }

    public function action()
    {
        return $this->belongsToMany(Action::class, 'action_attachment', 'attachment_id', 'action_id')->withTimestamps();
    }
}
