<template>
    <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
        <b-navbar-brand :to="{path: '/'}">Prueba B-GRC</b-navbar-brand>
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
            <b-nav-item :to="{path:'/vehiculos'}">  Vehiculos  </b-nav-item> 
            <b-nav-item :to="{path:'/personas'}">  personas  </b-nav-item> 
        </b-navbar-nav>
        </b-collapse>
    </b-navbar>
    </div>
</template>

<script>
    export default {
        name:'NavHeader'
    }
</script>

<style lang="scss" scoped>

</style>