<template>
    <b-container>
        <Loading v-if="validating"/>
        <Content v-else/>
    </b-container>
</template>
<script>
    // @ is an alias to /src
    import Content from "@/template/Content";
    import {userKey} from "@/global";
    import {mapState} from 'vuex';
    import Loading from "@/template/Loading";
    import api from "@/api";

    export default {
        name: 'App',
        components: {
            Loading,
            Content
        },
        data() {
            return {
                validating: true
            }
        },
        computed: mapState(['user']),
        methods: {
            validateToken() {
                this.validating = true

                const json = localStorage.getItem(userKey)
                const userData = JSON.parse(json)
                this.$store.commit('setUser', null)

                if (!userData) {
                    this.validating = false;
                    this.$router.push({name: 'Auth'})
                    return
                }

                api.get(`/user-profile`).then(() => {
                    this.validating = false
                    this.$store.commit('setUser', userData)
                }).catch((e) => {
                    this.validating = false
                })
            }
        },
        created() {
            this.validateToken()
        }
    }
</script>
