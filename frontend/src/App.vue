<template>
    <b-container>
        <Loading v-if="validating"/>
        <b-row v-if="!validating && user">
            <b-col></b-col>
            <b-col sm="12" md="8">
                <b-card title="Card Title" no-body class="mt-2">
                    <b-card-header header-tag="nav">
                        <div class="d-flex justify-content-between">
                            <Menu/>
                            <Logout/>
                        </div>
                    </b-card-header>

                    <b-card-body>
                        <Content/>
                    </b-card-body>
                </b-card>
            </b-col>
            <b-col></b-col>
        </b-row>
        <b-row v-if="!validating && !user">
            <Content/>
        </b-row>
    </b-container>
</template>
<script>
    // @ is an alias to /src
    import Content from "@/template/Content";
    import Menu from "@/template/Menu";
    import {userKey, baseApiUrl} from "@/global";
    import axios from "axios";
    import {mapState} from 'vuex';
    import Loading from "@/template/Loading";
    import Logout from "@/template/Logout";

    export default {
        name: 'App',
        components: {
            Logout,
            Loading,
            Content, Menu
        },
        data() {
            return {
                validating: true
            }
        },
        computed: mapState(['user']),
        methods: {
            async validateToken() {

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

                const res = await axios.get(`${baseApiUrl}/user-profile`, config)

                console.log(userData)
                if (res.data) {
                    this.$store.commit('setUser', userData)
                } else {
                    localStorage.removeItem(userKey)
                    this.$router.push({name: 'Auth'})
                }

                this.validating = false;
            }
        },
        created() {
            this.validateToken()
        }
    }
</script>
