<template>
  <div class="container">
    <form class="form-group" @submit.prevent="salvar">
      <div class="row">
        <div class="col-sm-12 mb-3">
          <label for="Nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="nome" name="nome" v-model="doctor.name" placeholder="Digite seu nome...">
        </div>        
      </div>
      <div class="row">
        <div class="col-sm-3 mb-3">
          <label for="CPF" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" name="cpf" v-model="doctor.cpf" placeholder="Digite seu CPF...">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="RG" class="form-label">RG</label>
          <input type="text" class="form-control" id="rg" name="rg" v-model="doctor.rg" placeholder="Digite seu RG...">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="CRM" class="form-label">CRM</label>
          <input type="text" class="form-control" id="crm" name="crm" v-model="doctor.crm" placeholder="Digite seu CRM...">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 mb-3">
          <label for="DataNascimento" class="form-label">Data de Nascimento</label>
          <input type="date" class="form-control" id="datanascimento" name="datanascimento" v-model="doctor.birthdate" placeholder="Digite seu RG...">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="" class="form-label">Genero</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" v-model="doctor.gender" value="F">
            <label class="form-check-label" for="inlineRadio1">Feminino</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" v-model="doctor.gender" value="M">
            <label class="form-check-label" for="inlineRadio2">Masculino</label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 mb-3">
          <label for="Email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" v-model="doctor.email" placeholder="carlos@exemplo.com">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="Celular" class="form-label">Celular</label>
          <input type="text" class="form-control" id="celular" name="celular" v-model="doctor.phonenumber" placeholder="(99) 99999-9999">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="Telefone" class="form-label">Telefone</label>
          <input type="text" class="form-control" id="telefone" name="telefone" v-model="doctor.telephone" placeholder="(99) 99999-9999">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 mb-3">
          <label for="CEP" class="form-label">CEP</label>
          <input type="text" class="form-control" id="cep" name="cep" v-model="doctor.cep" placeholder="Digite seu CEP...">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="Rua" class="form-label">Rua</label>
          <input type="text" class="form-control" id="rua" name="rua" v-model="doctor.street" placeholder="Digite seu Rua...">
        </div>
        <div class="col-sm-2 mb-3">
          <label for="Numero" class="form-label">Número</label>
          <input type="text" class="form-control" id="numero" name="numero" v-model="doctor.number" placeholder="Digite seu Número...">
        </div>
        <div class="col-sm-2 mb-3">
          <label for="Bairro" class="form-label">Bairro</label>
          <input type="text" class="form-control" id="bairro" name="bairro" v-model="doctor.district" placeholder="Digite seu Bairro...">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 mb-3">
          <label for="Cidade" class="form-label">Cidade</label>
          <input type="text" class="form-control" id="cidade" name="cidade" v-model="doctor.city" placeholder="Digite seu Cidade...">
        </div>
        <div class="col-sm-3 mb-3">
          <label for="Estado" class="form-label">Estado</label>
          <input type="text" class="form-control" id="estado" name="estado" v-model="doctor.state" placeholder="Digite seu Estado...">
        
        </div>
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       <button type="submit" class="btn btn-success">Confirmar</button>
       <button v-on:click=(cancelar()) type="button" class="btn btn-warning">Cancelar</button>
      </div>
    </form>
  </div>
</template>
<script lang="ts">

import Doctor from '../services/Doctor'
export default {
  name: 'Doctor',
  props: ['id'],
  data () {
    return {
      pesquisar:'',
      doctor:{
        id: '',
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
        state: '',
        specialties:[1]
      },
      doctors: [],
      message: []
    }
  },
  mounted(){
    debugger;
    if(this._props.id){
      this.preencher(this._props.id)
    }
  },
  methods:{
    preencher(id){
        Doctor.buscar(id).then(response => { 
        console.log(response.data);               
        this.doctor = response.data;
      }).catch(e => {        
        console.log(e)
      })
    },
    salvar(){
      console.log(this.doctor);
      if(!this.doctor.id){         
          Doctor.salvar(this.doctor).then(response =>{            
            this.message = response.status;
          })                 
          
      }else{
        Doctor.atualizar(this.doctor).then(response =>{
            this.message = response.status;
        })
      } 
      this.$router.push('/')     
    },
    editar(doctor){
      this.doctor = doctor
    },
    cancelar(){      
      this.doctor = {};
      this.$router.push('/');
    }
    
    
  }
  
}
</script>