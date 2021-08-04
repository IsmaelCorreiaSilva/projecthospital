import { http } from './config'

export default	{

	salvar:(specialty)=>{
		return http.post('specialty',specialty);
  },
    
	atualizar:(specialty)=>{
		return http.put('specialty',specialty);
  },

  listar:()=>{
		return http.get('specialty');
  },

	buscar:(id)=>{
		return http.get('specialty/' + id);
  },

	listarPorNome:(nome)=>{
		return http.get('specialty/findbyname/' + nome);
  },
    
	apagar:(id)=>{
		return http.delete('specialty/' + id);
	}
}