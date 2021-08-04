<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class DoctorController extends Controller
{
    private $doctor;
    
    public function __construct(Doctor $doctor){
        $this->doctor = $doctor;
    }

    public function getAll(){
        try {
            return response()->json($this->doctor->all());
        } catch (\Exception $e) {
            return response()->json('Erro ao buscar dados', 500);
        }
    }

    public function get($id){
        $doctor = $this->doctor->find($id);
        
        if(!$doctor)
           return reponse()->json('Erro ao buscar dados',404);
        
        return response()->json($doctor);
    }
    public function getByName($name){
        $doctors = Doctor::where('name', 'ilike', '%' . $name . '%')
        ->orWhere('crm', 'ilike', '%' . $name . '%')
        ->orWhere('cpf', 'ilike', '%' . $name . '%')
        ->orWhere('rg', 'ilike', '%' . $name . '%')->get();
        
        if(!$doctors)
           return reponse()->json('Erro ao buscar dados',404);
        
        return response()->json($doctors);
    }
    public function getBySpecialty($specialty){        
        $doctors = Doctor::whereHas('specialties', function (Builder $query) use($specialty) {
            $query->where('name', 'ilike', $specialty);            
        })->get();

        if(!$doctors)
           return reponse()->json('Erro ao buscar dados',404);
        
        return response()->json($doctors);
    }

    public function create(Request $request)
    {

        try {
            
            $doctor = new Doctor();

            $doctor->name = request('name', $default = '');
            $doctor->rg = request('rg', $default = '');
            $doctor->cpf = request('cpf', $default = '');
            $doctor->crm = request('crm', $default = '');
            $doctor->birthdate = request('birthdate', $default = '');
            $doctor->phonenumber = request('phonenumber', $default = '');
            $doctor->telephone = request('telephone', $default = '');
            $doctor->email = request('email', $default = '');
            $doctor->gender = request('gender', $default = '');
            $doctor->street = request('street', $default = '');
            $doctor->number = request('number', $default = '');
            $doctor->cep = request('cep', $default = '');
            $doctor->district = request('district', $default = '');
            $doctor->city = request('city', $default = '');
            $doctor->state = request('state', $default = '');            

           
            $doctor->save();

            $specialties = request('specialties', $default = null);

            $doctor->specialties()->attach($specialties);
            
            return response()->json($doctor, 201);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);            
        }
    }

    
    public function update(Request $request)
    {

        try {
                        
            $doctor = Doctor::find(request('id', $default = 0));

            if ($doctor == null) {
                return response()->json(null, 404);
            }

            $doctor->name = request('name', $default = '');
            $doctor->rg = request('rg', $default = '');
            $doctor->cpf = request('cpf', $default = '');
            $doctor->crm = request('crm', $default = '');
            $doctor->birthdate = request('birthdate', $default = '');
            $doctor->phonenumber = request('phonenumber', $default = '');
            $doctor->telephone = request('telephone', $default = '');
            $doctor->email = request('email', $default = '');
            $doctor->gender = request('gender', $default = '');
            $doctor->street = request('street', $default = '');
            $doctor->number = request('number', $default = '');
            $doctor->cep = request('cep', $default = '');
            $doctor->district = request('district', $default = '');
            $doctor->city = request('city', $default = '');
            $doctor->state = request('state', $default = '');            

           
            $doctor->save();

            $specialties = request('specialties', $default = null);

            $doctor->specialties()->sync($specialties);
            
            return response()->json($doctor, 201);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);            
        }
    }
    public function delete($id){        
        try {
            $doctor = Doctor::find($id);
            if(!is_null($doctor)){
                $doctor->specialties()->detach();            
                $doctor->delete();
            }
            return response()->json('Removido com sucesso!!!', 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }
    }
}
