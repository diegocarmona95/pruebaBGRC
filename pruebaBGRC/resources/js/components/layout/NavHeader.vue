<template>
<v-app>
   
    <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
        <b-navbar-brand href="#">Prueba B-GRC</b-navbar-brand>
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
            <b-nav-item :to="{path:'/vehiculos'}">  Vehiculos  </b-nav-item> 
            <b-nav-item :to="{path:'/personas'}">  Personas  </b-nav-item> 
        </b-navbar-nav>
        </b-collapse>
    </b-navbar>
    </div>
    <router-view/>
</v-app>

</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>