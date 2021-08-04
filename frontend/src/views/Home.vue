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
            <router-link to="/create" class="btn btn-success" tabindex="-1" role="button" aria-disabled="true">Adicionar</router-link>
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
            <th scope="col">CPF</th>
            <th scope="col">CRM</th>
            <th scope="col">RG</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doctor in doctors" :key="doctor.id">
            <th scope="row">{{doctor.id}}</th>
            <td>{{doctor.name}}</td>
            <td>{{doctor.cpf}}</td>
            <td>{{doctor.crm}}</td>
            <td>{{doctor.rg}}</td>

            <td>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button v-on:click="editar(doctor)" type="button" class="btn btn-success" tabindex="-1" role="button" aria-disabled="true">Editar</button>
                <button @click="deletar(doctor)" type="button" class="btn btn-success" tabindex="-1" role="button" aria-disabled="true">Excluir</button>
              </div>
            </td>
          </tr>         
        </tbody>
      </table>
    </div>
  </div>
</template>
<script lang="ts">

import Doctor from '../services/Doctor'
export default {
  name: 'Home',
  data () {
    return {
      pesquisar:'',
      doctor:{
        id: 0,
        name: '',
        cpf:'',
        rg:'',
        crm:'',
        birthdate:'',
        phonenumber:'',
        telephone:'',
        email:'',
        gender:'',
        street:'',
        number:'',
        cep:'',
        district:'',
        city:'',
        state: ''
      },
      doctors: [],
      errors: []
    }
  },
  mounted(){
    this.listar();
  },
  methods:{
    
    listar(){
      Doctor.listar().then(response => {
        //console.log(response.data);
        this.doctors = response.data;
      }).catch(e => {
        console.log(e)
      })
    },
    listarPorNome(name){
      if(name===''){
        this.listar();
      }else{
        Doctor.listarPorNome(name).then(response => {                
          this.doctors = response.data;
        }).catch(e => {        
          console.log(e)
        })
      }
    },
    editar(doctor){
      this.$router.push('/create/'+ doctor.id)
    },
    deletar(doctor){
      if(confirm('Deseja excluir o Médico(a)?')){
        Doctor.apagar(doctor.id).then(response => {
          this.message = response.status;
        }).catch(e =>{
          console.log(e)
        });
        this.$router.push('/');
      }
    }
    
  }
  
}
</script>