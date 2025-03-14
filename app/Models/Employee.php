<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'contact_number',
        'email'
    ];

    public function actions()
    {
        return $this->belongsToMany(Action::class, 'employee_action', 'employee_id', 'action_id')->withTimestamps();
    }
}
