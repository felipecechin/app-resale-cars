<template>
    <b-row>
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
                    <h1>Dashboard</h1>
                </b-card-body>
            </b-card>
        </b-col>
        <b-col></b-col>
    </b-row>

</template>

<script>
    // @ is an alias to /src


    import api from "@/api";
    import Logout from "@/template/Logout";
    import Menu from "@/template/Menu";

    export default {
        name: 'Home',
        components: {Menu, Logout},
        methods: {
            async getFuncs() {
                const res = await api.get(`/cars`)
                console.log(res)
            }
        },
        mounted() {
            this.getFuncs();
        }
    }
</script>
