<template>
    <div>

       <nav-header/>
        <div class="container">
        <router-view/>
        </div>
     
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