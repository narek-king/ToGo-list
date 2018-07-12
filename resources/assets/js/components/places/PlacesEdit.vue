<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit place</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-8 form-group">
                            <label class="control-label">ToGo place name</label>
                            <input type="text" v-model="place.name" class="form-control">
                        </div>
                        <div class="col-8 form-group">
                            <label class="control-label" for="is-visited">Is Visited?</label>
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
            const id = this.$route.params.id;
            this.placeId = id;
            axios.get('/places/' + id)
                .then((resp) => {
                    this.place = resp.data;
                    (this.place.visited === '1')? this.place.visited = true : this.place.visited = false;
                })
                .catch(() => {
                    alert("Could not load your place")
                });
        },
        data:() => {
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
                const newPlace = this.place;
                axios.patch('/places/' + this.placeId, newPlace)
                    .then((resp) => {
                        this.$router.replace('/');
                    })
                    .catch((resp) => {
                        alert("Could not create your place");
                    });
            }
        }
    }
</script>
