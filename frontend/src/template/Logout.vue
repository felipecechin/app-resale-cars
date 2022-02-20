<template>
    <b-nav>
        <a href @click.prevent="logout" class="nav-link link-secondary">Sair</a>
    </b-nav>
</template>

<script>
    import {mapState} from "vuex";
    import {userKey} from "@/global";
    import api from "@/api";

    export default {
        name: "Logout",
        computed: mapState(['user']),
        methods: {
            async logout() {
                await api.post(`/logout`)
                localStorage.removeItem(userKey)
                this.$store.commit('setUser', null)
                this.$router.push({name: 'Auth'})
            }
        }
    }
</script>

<style scoped>

</style>
