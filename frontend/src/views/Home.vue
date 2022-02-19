<template>
    <AppTemplate>
        <template v-slot:content>
            <h1>DASHBOARD</h1>
        </template>
    </AppTemplate>
</template>

<script>
    // @ is an alias to /src


    import api from "@/api";
    import AppTemplate from "@/template/AppTemplate";

    export default {
        name: 'Home',
        components: {AppTemplate},
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
