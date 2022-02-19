<script>
    import {defineComponent} from 'vue'
    import {Doughnut} from 'vue3-chart-v2'

    export default defineComponent({
        name: 'PieChart',
        extends: Doughnut,
        props: {
            chartData: {
                type: Object,
                required: true
            },
            chartOptions: {
                type: Object,
                required: false
            }
        },
        mounted() {
            // Overwriting base render method with actual data.
            this.renderChart(this.chartData, this.chartOptions)
        }
    })
</script>
