
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
                    </div>
                    <div class="row">
                        <div class="col-2 form-group">
                            <button class="btn btn-success">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                place: {
                    name: '',
                    coordinates: '{some trivial testing cord}',
                    visited: false
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                let app = this;
                let newPlace = app.place;
                axios.post('/api/v1/places', newPlace)
                    .then((resp) => {
                        app.$router.push({path: '/'});
                    })
                    .catch((resp) => {
                        console.log(resp);
                        alert("Could not create your place");
                    });
            }
        }
    }
</script>
