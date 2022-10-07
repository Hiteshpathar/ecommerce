<template>
    <PPage
        title="Analytics"
        fullWidth
    >
        <PStack>
            <PStackItem fill="">
                <PDatePicker
                    opens="left"
                    id="pDatePicker"
                    prefix=""
                    :singleDatePicker="false"
                    clearable
                    @change="updateDatepicker"
                />
            </PStackItem>
            <PStackItem>
                <PButton plain="">Delete</PButton>
            </PStackItem>
        </PStack>
        <br>
        <PLayout>
            <PLayoutSection oneThird="">
                <PCard :sectioned="false">
                    <PCardHeader
                        title="Total Sales"
                        :actions='[{"content":"View report","to":"/to-route"}]'
                    />
                    <PCardSection>
                        <PStack>
                            <PStackItem fill="">
                                <PDisplayText size="large">₹{{toInr(this.total)}}</PDisplayText>
                            </PStackItem>
                            <PStackItem>
                                <PDisplayText size="large">-</PDisplayText>
                            </PStackItem>
                        </PStack>
                        <PChart
                            title="Sales over time"
                            type="line"
                            width="100%"
                            height="200"
                            :series='this.series'
                            :xAxis='this.xAxis'
                            :chartOptions='this.chartOptions'
                        />
                    </PCardSection>
                </PCard>
            </PLayoutSection>
            <PLayoutSection oneThird="">
                <PCard title="Variant" sectioned="" :actions="[]">Add Variant</PCard>
            </PLayoutSection>
            <PLayoutSection oneThird="">
                <PCard title="Tags" sectioned="" :actions="[]">
                    Add tags to your order.
                </PCard>
            </PLayoutSection>
        </PLayout>
    </PPage>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "Index",
        data() {
            return {
                total: 0,
                series: [],
                xAxis: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                chartOptions: {"colors": ["#007B5C"]},
                queryParams: {
                    startDate: null,
                    endDate: null,
                },
                startDate: null,
                endDate: null,
            }
        },
        async created() {
            await this.loadSales(this.queryParams);
            this.series = [{'data': this.sales.sales}];
            this.total = this.sales.total;
        },
        watch: {
            queryParams: {
                deep: true,
                async handler() {
                    this.$router.replace({query: this.queryParams});
                    await this.loadSales(this.queryParams);
                    this.series = [{'data': this.sales.sales}];
                    this.total = this.sales.total;
                }
            },
        },
        computed: {
            ...mapGetters('analytics', {
                sales: 'getSales',
                errors: 'getErrors',
                message: 'getMessage'
            }),
        },
        methods: {
            ...mapActions('analytics', [
                'loadSales',
                'resetError',
            ]),
            updateDatepicker(val) {
                if (val.startDate) {
                    this.queryParams.startDate = val.startDate.getFullYear() + "-" + ("0" + (val.startDate.getMonth() + 1)).slice(-2) + "-" + ("0" + val.startDate.getDate()).slice(-2);
                    this.queryParams.endDate = val.endDate.getFullYear() + "-" + ("0" + (val.endDate.getMonth() + 1)).slice(-2) + "-" + ("0" + val.endDate.getDate()).slice(-2);
                } else {
                    this.queryParams.startDate = null
                    this.queryParams.endDate = null
                }
            },
            toInr(amount) {
                return (amount).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');
            }
        }
    }
</script>

<style scoped>

</style>
