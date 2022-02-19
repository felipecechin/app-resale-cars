<template>
    <b-row>
        <b-col></b-col>
        <b-col sm="12" md="8">
            <b-card title="Card Title" no-body class="mt-2 mb-2">
                <b-card-header header-tag="nav">
                    <div class="d-flex justify-content-between">
                        <Menu/>
                        <Logout/>
                    </div>
                </b-card-header>

                <b-card-body>
                    <slot name="content"></slot>
                </b-card-body>

                <b-card-footer v-if="this.$slots.footer">
                    <slot name="footer"></slot>
                </b-card-footer>
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
        name: 'AppTemplate',
        components: {Menu, Logout}
    }
</script>
