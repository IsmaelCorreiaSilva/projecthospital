<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Models\Doctor;
use App\Http\Controllers\DoctorController;

class SpecialtyController extends Controller
{
    private $specialty;
    
    public function __construct(Specialty $specialty){
        $this->specialty = $specialty;
    }
    public function getAll(){
        try {
            return response()->json($this->specialty->all());
        } catch (\Exception $e) {
            return response()->json('Erro ao buscar dados', 500);
        }
        
    }

    public function get($id){
        $specialty = $this->specialty->find($id);
        
        if(!$specialty)
            return response()->json('Erro ao buscar uma specialty!!!',404);

        return response()->json($specialty);
    }
    
    public function getByName($name){                
        $specialties = Specialty::where('name', 'ilike', '%' . $name . '%')
        ->orWhere('description', 'ilike', '%' . $name . '%')->get();
                
        if(!$specialties)
           return reponse()->json('Erro ao buscar dados',404);
        
        return response()->json($specialties);
    }
    public function create(Request $request)
    {
			try {
        
				$specialty = new Specialty();
                $specialty->name = request('name', $default = '');
                $specialty->description = request('description', $default = '');
				$specialty->save();
							
				return response()->json($specialty, 201);

			} catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
			}
    }
    public function update(Request $request){
        try {
            $data = $request->json()->all();
            $id = $data['id'];
            $specialty = Specialty::find($id);
            if(is_null($specialty)){
                throw new \Exception('Could not find object with id=' . $id );
            }
            $specialty->name = $data['name'];
            $specialty->description =  $data['description'];

            $specialty->save();

            return response()->json($specialty, 201);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }
    }

    public function delete($id){
        try {
                      
            $specialty = Specialty::find($id);
            $specialty->delete();

            return response()->json('Removido com sucesso', 200);
        } catch (\Illuminate\Database\QueryException $e){
            if ($e->getMessage()->contains("violates foreign key constraint")){
                return response()->json("resource in use, could not be removed",409);
            }
            return response()->json($e->getMessage(),500);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(),500);
        }
    }
}
