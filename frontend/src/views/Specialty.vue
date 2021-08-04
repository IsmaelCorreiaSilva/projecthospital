<template>
  <div class="container">
    <form class="form-group" @submit.prevent="salvar">
      <div class="row">
        <div class="col-sm-3 mb-3">
          <label for="Nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="nome" name="nome" v-model="specialty.name" placeholder="Digite um Nome...">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="Descricao" class="form-label">Descrição</label>
          <input type="text" class="form-control" id="descricao" name="descricao" v-model="specialty.description" placeholder="Digite uma Descrição...">
        </div>
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       <button type="submit" class="btn btn-success">Confirmar</button>
       <button v-on:click=(cancelar()) type="button" class="btn btn-warning">Cancelar</button>
      </div>
    </form>
  </div>
</template>
<script>
import Specialty from '../services/Specialty'
export default {
  props: ['id'],
  data () {
    return {
      name:'app',
      specialty:{   
        id:'',    
        name: '',
        description: ''
      },
      specialties: [],
      message: []
    }
  },
  mounted(){
    if(this._props.id){
      this.preencher(this._props.id)
    }
  },
  methods:{
    preencher(id){
      Specialty.buscar(id).then(response => {                
        this.specialty = response.data;
      }).catch(e => {        
        console.log(e)
      })
    },
    salvar(){
      if(!this.specialty.id){          
          Specialty.salvar(this.specialty).then(response =>{            
            this.message = response.message;
          })                 
          
      }else{
        Specialty.atualizar(this.specialty).then(response =>{
            this.message = response.message;
        })
      } 
      this.$router.push('/specialty')     
    },
    editar(specialty){
      this.specialty = specialty
    },
    cancelar(){      
      this.doctor = {};
      this.$router.push('/');
    }
    
  }
}
</script>