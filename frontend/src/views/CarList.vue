<template>
    <AppTemplate>
        <template v-slot:content>
            <b-form-row>
                <b-col cols="12" md="4">
                    <b-form-input
                        v-model="search"
                        placeholder="Pesquise pela marca ou modelo"></b-form-input>
                </b-col>
                <b-col cols="6" md="4" class="mt-2 mt-md-0">
                    <b-button variant="outline-primary" @click="searchCars()">Buscar</b-button>
                </b-col>
                <b-col cols="6" md="4" class="mt-2 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <router-link to="/car-form" tag="button" class="btn btn-primary">Novo carro</router-link>
                    </div>
                </b-col>
            </b-form-row>
            <Loading v-if="loading"/>
            <div class="table-responsive" v-else>
                <b-table striped hover :items="cars" :fields="fields">
                    <template #cell()="data">
                        {{ data.value }}
                    </template>
                    <template #cell(km)="data">
                        {{ formatNumber(data.value) }}
                    </template>


                    <template #cell(buttons)="data">
                        <div class="d-flex justify-content-end">
                            <b-button-group>
                                <router-link :to="'/car-form/'+data.item.id" tag="button" class="btn btn-success">
                                    Editar
                                </router-link>
                                <b-button variant="danger" class="ms-2" @click="showModalDelete(data.item)">Excluir
                                </b-button>
                            </b-button-group>
                        </div>
                    </template>
                </b-table>
            </div>
            <b-modal v-model="modalShow" title="Confirme a remoção" @ok="remove" @cancel="cancelRemove"
                     :ok-title="'Sim'"
                     :cancel-title="'Cancelar'">
                <span class="my-4" v-if="carRemove">Tem certeza que deseja deletar o carro de marca {{
                        carRemove.brand
                    }} e
                    modelo {{ carRemove.model }}?</span>
            </b-modal>
        </template>
        <template v-slot:footer v-if="!loading">
            <b-row>
                <b-col md="6">
                    <div class="d-flex justify-content-center justify-content-md-start" v-if="total > 0">
                        Mostrando {{ cars.length }} de {{ total }}.
                    </div>
                    <div class="d-flex justify-content-center justify-content-md-start" v-else>
                        Nenhum registro encontrado.
                    </div>
                </b-col>
                <b-col md="6">
                    <div class="d-flex justify-content-center justify-content-md-end mt-2 mt-md-0">
                        <v-pagination
                            v-model="page"
                            :pages="pages"
                            :range-size="1"
                            active-color="#DCEDFF"
                            @update:modelValue="updateHandler"
                        />
                    </div>
                </b-col>
            </b-row>
        </template>
    </AppTemplate>

</template>

<script>
    // @ is an alias to /src
    import VPagination from "@hennge/vue3-pagination";
    import "@hennge/vue3-pagination/dist/vue3-pagination.css";


    import api from "@/api";
    import AppTemplate from "@/template/AppTemplate";
    import {useToast} from "vue-toastification";
    import Loading from "@/template/Loading";
    import {showErrors} from "@/global";

    export default {
        name: 'CarList',
        setup() {
            const toast = useToast();
            return {toast};
        },
        components: {AppTemplate, VPagination, Loading},
        computed: {
            pages() {
                return Math.ceil(this.total / 10)
            },
            formatNumber() {
                return (value) => {
                    const number = Number(value)
                    return number.toLocaleString();
                }
            }
        },
        data() {
            return {
                search: '',
                page: 1,
                fields: [
                    {key: 'brand', label: 'Marca'},
                    {key: 'model', label: 'Modelo'},
                    {key: 'color', label: 'Cor'},
                    {key: 'km', label: 'Quilometragem'},
                    {key: 'transmission', label: 'Câmbio'},
                    {key: 'buttons'},
                ],
                cars: [],
                total: 0,
                loading: true,
                modalShow: false,
                carRemove: {}
            }
        },
        methods: {
            getCars(page, search) {
                this.loading = true;
                api.get('/cars?page=' + page + '&search=' + search).then((resp) => {
                    this.cars = resp.data.cars;
                    this.total = resp.data.total;
                }).catch((e) => {
                    this.toast.error('Ocorreu algum erro ao buscar os carros')
                }).finally(() => {
                    this.loading = false
                })
            },
            updateHandler(value) {
                this.getCars(value, this.search)
            },
            searchCars() {
                this.page = 1;
                this.getCars(this.page, this.search)
            },
            showModalDelete(car) {
                this.carRemove = car
                this.modalShow = !this.modalShow
            },
            remove() {
                api.delete('/cars/' + this.carRemove.id).then((resp) => {
                    this.toast.success(resp.data.message)
                    this.searchCars()
                }).catch((e) => {
                    showErrors(e)
                })
            },
            cancelRemove() {
                this.carRemove = {}
            }
        },
        mounted() {
            this.getCars(1, this.search);
        }
    }
</script>
