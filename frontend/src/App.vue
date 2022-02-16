<template>
    <b-container>
        <b-row v-if="user">
            <b-col></b-col>
            <b-col sm="12" md="8">
                <b-card title="Card Title" no-body class="mt-2">
                    <b-card-header header-tag="nav">
                        <Menu/>
                    </b-card-header>

                    <b-card-body>
                        <Content/>
                    </b-card-body>
                </b-card>
            </b-col>
            <b-col></b-col>
        </b-row>
        <b-row v-else>
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

    export default {
        name: 'App',
        components: {
            Content, Menu
        },
        computed: mapState(['user']),
        methods: {
            async validateToken() {

                const json = localStorage.getItem(userKey)
                const userData = JSON.parse(json)

                if (!userData) {
                    this.$router.push({name: 'Auth'})
                    return
                }
                const res = await axios.post(`${baseApiUrl}/user-profile`, {})

                console.log(res.data)
                if (res.data) {
                    console.log('ok');
                } else {
                    localStorage.removeItem(userKey)
                    this.$router.push({name: 'Auth'})
                }
            }
        },
        created() {
            this.validateToken()
        }
    }
</script>
