
<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-body">
                <google-map />
                <data-table />
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
                        <td>{{ (place.visited === '1')? 'visited': 'not visited' }}</td>
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
                            <a href="#"
                               class="btn btn-primary"
                               v-on:click="showOnMap(place)">
                                Show on the Map
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
    import GoogleMap from "./GoogleMap";
    import DataTable from "./DataTable";
    export default {
        components: {
            GoogleMap,
            DataTable
        },
        data: () => {
            return {
                places: []
            }
        },
        mounted() {
            axios.get('/places')
                .then((resp) => {
                    this.places = resp.data;
                    this.$bus.$emit('setPlaces', {data: this.places});
                })
                .catch((resp) => {
                    console.log(resp);
                    alert("Could not load places"); // TODO remove alerts
                });
            this.$bus.$on('placeAdded', (message) => {
                let coordinates = '';
                let name = '';
                if (message.data.geometry) {
                    coordinates = JSON.stringify({
                        lat: message.data.geometry.location.lat(),
                        lng: message.data.geometry.location.lng()
                    });
                    name = message.data.formatted_address;
                } else {
                    coordinates = JSON.stringify({
                        lat: message.data.position.lat,
                        lng: message.data.position.lng
                    });
                    name = message.data.content.title;
                }
                const newPlace = {
                    name: name,
                    coordinates: coordinates,
                    visited: false
                };
                axios.post('/places', newPlace)
                    .then((resp) => {
                        resp.data.visited = 0;
                        this.places.push(resp.data);
                    })
                    .catch((resp) => {
                        console.log(resp);
                        alert("Could not create your place"); // TODO remove alerts
                    });
            });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/places/' + id)
                        .then((resp) => {
                            this.places.splice(index, 1);
                            this.$bus.$emit('setPlaces', {data: this.places});
                        })
                        .catch((resp) => {
                            alert("Could not delete place"); // TODO remove alerts
                        });
                }
            },
            showOnMap(place) {
                this.$bus.$emit('showMarker', {place});
            }
        }
    }
</script>
