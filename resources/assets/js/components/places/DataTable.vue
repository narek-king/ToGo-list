<template>
    <vue-table class="box"
               path="/init"
               id="places">
    </vue-table>
</template>
<script>
    import VueTable from '../enso/vuedatatable/VueTable.vue'
    export default {
        name: "DataTable",
        components: {
            VueTable
        }
    }
</script>
