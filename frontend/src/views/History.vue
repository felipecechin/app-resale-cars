<template>
    <AppTemplate>
        <template v-slot:content>
            <b-form-row>
                <b-col cols="12" md="6">
                    <b-form-select v-model="searchUser" :options="optionsUser"></b-form-select>
                </b-col>
                <b-col cols="12" md="6">
                    <b-form-select v-model="searchType" :options="optionsType" class="mt-2 mt-md-0"></b-form-select>
                </b-col>
            </b-form-row>
            <Loading v-if="loading"/>
            <div class="table-responsive" v-else>
                <b-table striped hover :items="actions" :fields="fields">
                    <template #cell(user)="data">
                        {{ data.value.name }}
                    </template>
                    <template #cell(car)="data">
                        {{ data.value.brand }} - {{ data.value.model }}
                    </template>
                    <template #cell(occurrence)="data">
                        {{ formatDate(data.value) }}
                    </template>
                    <template #cell(type)="data">
                        {{ formatAction(data.value) }}
                    </template>
                </b-table>
            </div>
        </template>
        <template v-slot:footer v-if="!loading">
            <b-row>
                <b-col md="6">
                    <div class="d-flex justify-content-center justify-content-md-start" v-if="total > 0">
                        Mostrando {{ actions.length }} de {{ total }}.
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
    import AppTemplate from "@/template/AppTemplate";
    import VPagination from "@hennge/vue3-pagination";
    import Loading from "@/template/Loading";
    import api from "@/api";
    import moment from 'moment'

    export default {
        name: "History",
        components: {AppTemplate, VPagination, Loading},
        data() {
            return {
                searchUser: null,
                optionsUser: [
                    {value: null, text: 'Sem filtro de usuário'}
                ],
                searchType: null,
                optionsType: [
                    {value: null, text: 'Sem filtro de ação'},
                    {value: 'D', text: 'Remoção'},
                    {value: 'U', text: 'Atualização'},
                    {value: 'C', text: 'Cadastro'},
                ],
                page: 1,
                fields: [
                    {key: 'user', label: 'Usuário'},
                    {key: 'car', label: 'Carro'},
                    {key: 'occurrence', label: 'Data e hora'},
                    {key: 'type', label: 'Ação'}
                ],
                actions: [],
                total: 0,
                loading: true
            }
        },
        computed: {
            pages() {
                return Math.ceil(this.total / 10)
            },
            formatDate() {
                return (value) => {
                    if (!value) return ''
                    return moment(value).format('DD/MM/YYYY HH:mm')
                }
            },
            formatAction() {
                return (value) => {
                    if (value === 'D') return 'Remoção'
                    if (value === 'U') return 'Atualização'
                    if (value === 'C') return 'Cadastro'
                }
            }
        },
        methods: {
            getActions(page, user, type) {
                this.loading = true;
                let queryStr = ''
                if (user) {
                    queryStr += '&user=' + user
                }
                if (type) {
                    queryStr += '&type=' + type
                }
                api.get('/actions?page=' + page + queryStr).then((resp) => {
                    this.actions = resp.data.actions;
                    this.total = resp.data.total;
                }).catch((e) => {
                    this.toast.error('Ocorreu algum erro ao buscar o histórico')
                }).finally(() => {
                    this.loading = false
                })
            },
            updateHandler(value) {
                this.getActions(value, this.searchUser, this.searchType)
            },
            getUsers() {
                this.loading = true;
                api.get('/users').then((resp) => {
                    const users = resp.data.users.map((user) => {
                        return {
                            value: user.id,
                            text: user.name
                        }
                    });
                    this.optionsUser = this.optionsUser.concat(users)
                }).catch((e) => {
                    this.toast.error('Ocorreu algum erro ao buscar os usuários')
                }).finally(() => {
                    this.loading = false
                })
            }
        },
        mounted() {
            this.getActions(1, this.searchUser, this.searchType);
            this.getUsers();
        },
        watch: {
            searchUser: function (val) {
                this.page = 1;
                this.getActions(1, val, this.searchType)
            },
            searchType: function (val) {
                this.page = 1;
                this.getActions(1, this.searchUser, val)
            }
        }
    }
</script>

<style scoped>
</style>
