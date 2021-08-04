<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link class="nav-link" to="/">Médicos</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/specialty">Especialidades</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</template>
<script>
export default{
  name:"Navbar"
}

</script>
