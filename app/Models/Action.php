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
        'action_details',
        'status',
        'deadline'
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'action_attachment');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, table:'employee_action');
    }   
}
