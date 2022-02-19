<template>
    <b-container>
        <Loading v-if="validating"/>
        <Content v-else/>
    </b-container>
</template>
<script>
    // @ is an alias to /src
    import Content from "@/template/Content";
    import {userKey, baseApiUrl} from "@/global";
    import axios from "axios";
    import {mapState} from 'vuex';
    import Loading from "@/template/Loading";

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
                const config = {
                    headers: {
                        Authorization: 'bearer ' + userData.access_token,
                    }
                };

                axios.get(`${baseApiUrl}/user-profile`, config).then(() => {
                    this.$store.commit('setUser', userData)
                }).catch((e) => {
                    localStorage.removeItem(userKey)
                    this.$router.push({name: 'Auth'})
                }).finally(() => {
                    this.validating = false;
                })
            }
        },
        created() {
            this.validateToken()
        }
    }
</script>
