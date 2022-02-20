<template>
    <div>
        <b-nav card-header pills>
            <router-link to="/" class="nav-link" exact-active-class="active">Dashboard</router-link>
            <router-link to="/car-list" class="nav-link" exact-active-class="active">Carros</router-link>
            <router-link to="/car-form" v-if="this.$route.name === 'CarForm'" class="nav-link"
                         :class="[{'router-link-active active': this.$route.path.indexOf('car-form') > -1 }]">
                {{ this.$route.params.id ? 'Editar' : 'Adicionar' }} carro
            </router-link>
            <router-link to="/history" class="nav-link" exact-active-class="active">Histórico de ações</router-link>
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
