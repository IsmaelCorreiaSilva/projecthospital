<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specialty;

class Doctor extends Model
{
    use HasFactory;
    
    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'rg',
        'cpf',
        'crm',
        'birthdate',
        'phonenumber',
        'telephone',
        'email',
        'gender',
        'street',
        'number',
        'cep',
        'district',
        'city',
        'state'
    ]; 

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class);
        // return $this->belongsToMany(Specialty::class, 'doctor_specialty_table', 'doctor_id', 'specialty_id');
    }
}
