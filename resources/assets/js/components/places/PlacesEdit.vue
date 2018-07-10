<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Create new place</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-8 form-group">
                            <label class="control-label">ToGo list</label>
                            <input type="text" v-model="place.name" class="form-control">
                        </div>
                        <div class="col-8 form-group">
                            <label class="control-label" for="is-visited">Is Visited? {{ place.visited }}</label>
                            <input type="checkbox" id="is-visited" v-model="place.visited" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 form-group">
                            <button class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.placeId = id;
            axios.get('/api/v1/places/' + id)
                .then((resp) => {
                    console.log(resp);
                    app.place = resp.data;
                    (app.place.visited === '1')? app.place.visited = true : app.place.visited = false;
                })
                .catch(() => {
                    alert("Could not load your place")
                });
        },
        data: function () {
            return {
                placeId: null,
                place: {
                    name: '',
                    visited: false
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                let app = this;
                let newPlace = app.place;
                axios.patch('/api/v1/places/' + app.placeId, newPlace)
                    .then((resp) => {
                        app.$router.replace('/');
                    })
                    .catch((resp) => {
                        console.log(resp);
                        alert("Could not create your place");
                    });
            }
        }
    }
</script>
