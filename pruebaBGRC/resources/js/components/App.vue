<template>
    <div>
       <nav-header/>
        <div class="container">
         <h2> hola app </h2>
        </div>
        <nav-footer />
    </div>
</template>

<script>
import NavHeader from './layout/NavHeader.vue';
import NavFooter from './layout/NavFooter.vue';
    export default {
        components:{NavHeader, NavFooter}
    }
</script>

<style lang="scss" scoped>

</style>