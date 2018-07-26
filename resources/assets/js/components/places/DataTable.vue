<template>
    <!--<vue-filter class="box"-->
    <!--:options="visitedOptions"-->
    <!--icons-->
    <!--title="Visited"-->
    <!--v-model="visited">-->
    <!--</vue-filter>-->
    <vue-table class="box"
               path="/init"
               id="places"
               @edit="edit"
               @destroy="destroy"
               @clicked="clicked">
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
                visitedOptions: [
                    { value: 1, label: 'check', class: 'has-text-success' },
                    { value: 0, label: 'times', class: 'has-text-danger' },
                ],
            }
        },
        methods: {
            edit(column, row) {
                this.$router.push({name: 'editPlace', params: {id: column.dtRowId}});
            },
            destroy(column, row) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/places/' + column.dtRowId)
                        .then((resp) => {console.log('deleted');
                        })
                        .catch((resp) => {
                            alert("Could not delete place"); // TODO remove alerts
                        });
                }
            },
            clicked(column) {
                this.$bus.$emit('showMarker', column.row.dtRowId);
            }
        }
    }
</script>
