<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class Specialty extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
    ];

    public function doctors()
    {
        // return $this->belongsToMany(Doctor::class, 'doctor_specialty_table', 'specialty_id', 'doctor_id');
        return $this->belongsToMany(Doctor::class);
    }
}
