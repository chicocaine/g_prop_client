<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /** @use HasFactory<\Database\Factories\ActionFactory> */
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'name',
        'details',
        'status',
        'deadline'
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'action_attachment', 'action_id', 'attachment_id')->withTimestamps();    
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'employee_action', 'action_id', 'employee_id')->withTimestamps();
    }   
}
