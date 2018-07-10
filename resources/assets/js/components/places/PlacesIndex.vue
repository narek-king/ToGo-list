
<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createPlace'}" class="btn btn-success">Create new place</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Places list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Visited</th>
                        <th>createdAt</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="place, index in places">
                        <td>{{ place.name }}</td>
                        <td>{{ (place.visited === '0')? 'not visited': 'visited' }}</td>
                        <td>{{ place.created_at }}</td>
                        <td>
                            <router-link :to="{name: 'editPlace', params: {id: place.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(place.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                places: []
            }
        },
        mounted() {
            let app = this;
            axios.get('/api/v1/places')
                .then((resp) => {
                    app.places = resp.data;
                })
                .catch((resp) => {
                    console.log(resp);
                    alert("Could not load places");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    let app = this;
                    axios.delete('/api/v1/places/' + id)
                        .then((resp) => {
                            app.places.splice(index, 1);
                        })
                        .catch((resp) => {
                            alert("Could not delete place");
                        });
                }
            }
        }
    }
</script>
