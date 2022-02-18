<template>
    <b-nav>
        <a href @click.prevent="logout" class="nav-link"><i class="fa fa-sign-out"></i> Sair</a>
    </b-nav>
</template>

<script>
    import {mapState} from "vuex";
    import {baseApiUrl, userKey} from "@/global";
    import api from "@/api";

    export default {
        name: "Logout",
        computed: mapState(['user']),
        methods: {
            async logout() {
                await api.post(`${baseApiUrl}/logout`)
                localStorage.removeItem(userKey)
                this.$store.commit('setUser', null)
                this.$router.push({name: 'Auth'})
            }
        }
    }
</script>

<style scoped>

</style>
