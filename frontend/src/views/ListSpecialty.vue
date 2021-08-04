<template>
  <div class="container">
    <br>
    <div>
      <form class="form-group" @submit.prevent="listarPorNome(pesquisar)">
        <div class="row">
          <div class="col-sm-6 mb-3">
            <input type="text" class="form-control" id="pesquisa" name="pesquisa" v-model="pesquisar" placeholder="Digite sua Pesquisa...">
          </div>
          <div class="col-sm-2 mb-3 d-grid gap-2 d-md-flex">
            <button type="submit" class="btn btn-primary"  tabindex="-1" role="button" aria-disabled="true">Pesquisar</button>
            <router-link to="/specialty/create" class="btn btn-success" tabindex="-1" role="button" aria-disabled="true">Adicionar</router-link>
          </div>
          <div class="col-sm-2 mb-3">
          </div>
        </div>
      </form>
    </div>
    <br>
    <div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="specialty in specialties" :key="specialty.id">
            <th scope="row">{{specialty.id}}</th>
            <td>{{specialty.name}}</td>
            <td>{{specialty.description}}</td>
            <td>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button v-on:click="editar(specialty)" class="btn btn-success" tabindex="-1" role="button" aria-disabled="true">Editar</button>
                <button v-on:click="deletar(specialty)" class="btn btn-success" tabindex="-1" role="button" aria-disabled="true">Excluir</button>
              </div>
            </td>
          </tr>         
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import Specialty from '../services/Specialty'
export default {
  name: 'app',
  data () {
    return {
      pesquisar:'',
      specialty:{
        id: 0,
        name: '',
        description: ''
      },
      specialties: [],
      errors: []
    }
  },
  mounted(){
    this.listar();
  },
  methods:{
    
    listar(){
      Specialty.listar().then(response => {
        //console.log(response.data);
        this.specialties = response.data;
      }).catch(e => {
        console.log(e)
      })
    },
    listarPorNome(name){
      if(name === '')
      {
        this.listar();
      }
      else 
      {
        Specialty.listarPorNome(name).then(response => {                
          this.specialties = response.data;
        }).catch(e => {        
          console.log(e)
        })
      }
    },
    editar(epecialty){
      this.$router.push('/specialty/create/'+ epecialty.id)
    },
    deletar(specialty){
      if(confirm('Deseja excluir o produto?')){
        debugger;
        Specialty.apagar(specialty.id).then(response => {
          this.message = response.message;
        }).catch(e =>{
          console.log(e)
        });
        this.$router.push('/specialty');
      }
    }
    
  }
  
}
</script>