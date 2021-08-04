import { http } from './config'

export default	{

	salvar:(doctor)=>{
		return http.post('doctor',doctor);
  },
    
	atualizar:(doctor)=>{
		return http.put('doctor',doctor);
  },

  listar:()=>{
		return http.get('doctor')
  },
  listarPorNome:(nome)=>{
		return http.get('doctor/findbyname/' + nome);
  }, 
	buscar:(id)=>{
		return http.get('doctor/' + id);
  },
	apagar:(id)=>{
		return http.delete('doctor/'+ id)
	}
}