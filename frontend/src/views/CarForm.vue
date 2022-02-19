<template>
    <AppTemplate>
        <template v-slot:content>
            <b-form @submit="save" v-if="!loading">
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Marca:">
                            <b-form-input
                                v-model="car.brand"
                                type="text"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Modelo:">
                            <b-form-input
                                v-model="car.model"
                                type="text"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Quilometragem:">
                            <b-form-input
                                v-model.number="car.km"
                                type="number"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Cor:">
                            <b-form-input
                                v-model="car.color"
                                type="text"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Câmbio:">
                            <b-form-input
                                v-model="car.transmission"
                                type="text"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="12">
                        <hr/>
                        <div class="d-flex justify-content-end">
                            <b-button type="submit" variant="primary">Salvar
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </b-form>
        </template>
    </AppTemplate>
</template>

<script>
    import AppTemplate from "@/template/AppTemplate";
    import {showErrors} from "@/global";
    import api from "@/api";
    import {useToast} from "vue-toastification";


    export default {
        name: "CarForm",
        components: {AppTemplate},
        props: ['id'],
        setup() {
            const toast = useToast();
            return {toast};
        },
        data() {
            return {
                car: {},
                loading: true
            }
        },
        methods: {
            save() {
                const method = this.car.id ? 'put' : 'post'
                const id = this.car.id ? `/${this.car.id}` : ''
                api[method]('/cars' + id, this.car)
                    .then((res) => {
                        this.toast.success(res.data.message)
                        if (method === "post") {
                            this.car = {}
                        }
                    }).catch((e) => {
                    showErrors(e)
                })
            }
        },
        mounted() {
            if (this.$route.params.id) {
                api.get('/cars/' + this.$route.params.id).then((res) => {
                    this.car = res.data
                }).catch((e) => {
                    showErrors(e)
                }).finally(() => {
                    this.loading = false
                })
            } else {
                this.loading = false
            }
        }
    }
</script>

<style scoped>

</style>
