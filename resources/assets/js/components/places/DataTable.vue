<template>
    <vue-table class="box"
               path="/init"
               id="places"
               @edit="edit">
    </vue-table>
</template>
<script>
    import VueTable from '../enso/vuedatatable/VueTable.vue'
    export default {
        name: "DataTable",
        components: {
            VueTable
        },
        data() {
            return{
                key: ''
            }
        },
        methods: {
            edit(column, row) {
                this.$router.push({name: 'editPlace', params: {id: column.dtRowId}});
            }
        }
    }
</script>
