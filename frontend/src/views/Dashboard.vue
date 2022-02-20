<template>
    <AppTemplate>
        <template v-slot:content>
            <Loading v-if="loading"/>
            <b-row v-else>
                <b-col md="12">
                    <h2>Carros cadastrados:
                        <b-badge>{{ totalCars }}</b-badge>
                    </h2>
                    <hr/>
                </b-col>
            </b-row>
            <b-row v-if="!loading">
                <b-col md="6">
                    <BarChart v-if="!loading" v-bind:chart-data="chartUserActions"
                              v-bind:chart-options="chartOptionsUserActions"/>
                </b-col>
                <b-col md="6">
                    <PieChart v-if="!loading" v-bind:chart-data="chartTypeActions"
                              v-bind:chart-options="chartOptionsTypeActions"/>
                </b-col>
            </b-row>
        </template>
    </AppTemplate>
</template>

<script>
    import AppTemplate from "@/template/AppTemplate";
    import api from "@/api";
    import {useToast} from "vue-toastification";
    import BarChart from '../chart/BarChart'
    import PieChart from "@/chart/PieChart";
    import Loading from "@/template/Loading";

    export default {
        name: "Dashboard",
        components: {Loading, AppTemplate, BarChart, PieChart},
        setup() {
            const toast = useToast();
            return {toast};
        },
        data() {
            return {
                userActions: [],
                typeActions: [],
                totalCars: 0,
                loading: true,
                chartOptionsUserActions: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Número de ações por usuário cadastrado'
                    },
                    legend: {
                        display: false
                    },
                    animation: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                userCallback: function (label, index, labels) {
                                    if (Math.floor(label) === label) {
                                        return label;
                                    }
                                }
                            }
                        }]
                    }
                },
                chartOptionsTypeActions: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Número de ocorrências de cada ação'
                    },
                    animation: false
                }
            }
        },
        computed: {
            chartUserActions() {
                return {
                    labels: this.userActions.map((el) => el.name),
                    datasets: [
                        {
                            label: 'Número de ações por usuário',
                            backgroundColor: '#bcffe4',
                            data: this.userActions.map((el) => el.count)
                        }
                    ]
                }
            },
            chartTypeActions() {
                const colors = this.typeActions.map((el) => {
                    if (el.type === 'C') {
                        return '#14b95d';
                    } else if (el.type === 'U') {
                        return '#0e1d9c';
                    } else if (el.type === 'D') {
                        return '#ff4933'
                    }
                });

                return {
                    labels: this.typeActions.map((el) => {
                        if (el.type === 'C') {
                            return 'Cadastro';
                        } else if (el.type === 'U') {
                            return 'Atualização';
                        } else if (el.type === 'D') {
                            return 'Remoção'
                        }
                    }),
                    datasets: [
                        {
                            label: 'Número de ações por usuário',
                            backgroundColor: colors,
                            data: this.typeActions.map((el) => el.count)
                        }
                    ]
                }
            }
        },
        methods: {
            getDashboard() {
                api.get('/dashboard').then((res) => {
                    this.userActions = res.data.userActions;
                    this.typeActions = res.data.typeActions;
                    this.totalCars = res.data.totalCars;
                }).catch(() => {
                    this.toast.error('Ocorreu algum erro ao buscar os dados')
                }).finally(() => {
                    this.loading = false
                })
            }
        },
        mounted() {
            this.getDashboard()
        }
    }
</script>

<style scoped>

</style>
