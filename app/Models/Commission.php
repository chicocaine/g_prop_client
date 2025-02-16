<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    /** @use HasFactory<\Database\Factories\CommissionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'set_price',
        'commission_details',
        'delivery_address',
        'status',
        'deadline',
        'completed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'commission_attachment', 'commission_id', 'attachment_id')->withTimestamps();
    }

}
