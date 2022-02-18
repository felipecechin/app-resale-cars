<template>
    <div>
        <b-nav card-header pills>
            <router-link to="/" class="nav-link" exact-active-class="active">Home</router-link>
            <router-link to="/about" class="nav-link" exact-active-class="active">About</router-link>
        </b-nav>
    </div>
</template>

<script>
    export default {
        name: "Menu"
    }
</script>

<style scoped>

</style>
