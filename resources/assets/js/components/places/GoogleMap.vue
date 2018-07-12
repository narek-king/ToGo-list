<template>
    <div>
        <div>
            <h2>Search and add a pin</h2>
            <label>
                <gmap-autocomplete
                        @place_changed="setPlace">
                </gmap-autocomplete>
                <button @click="addMarker">Add</button>
            </label>
            <br/>

        </div>
        <br>
        <gmap-map
                :center="center"
                :zoom="2"
                style="width:100%;  height: 600px;"
        >
            <gmap-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    @click="center=m.position"
            ></gmap-marker>
        </gmap-map>
    </div>
</template>

<script>
    export default {
        name: "GoogleMap",
        data() {
            return {
                center: { lat: 0, lng: 0 },
                markers: [],
                places: [],
                currentPlace: null
            };
        },

        mounted() {
            this.$bus.$on('setPlaces', (message) => {this.setMarkers(message.data)});
        },

        methods: {
            // receives a place object via the autocomplete component
            setPlace(place) {
                this.currentPlace = place;
            },
            addMarker() {
                if (this.currentPlace) {
                    this.$bus.$emit('placeAdded', {data: this.currentPlace});
                    const marker = {
                        lat: this.currentPlace.geometry.location.lat(),
                        lng: this.currentPlace.geometry.location.lng()
                    };
                    this.markers.push({ position: marker });
                    this.places.push(this.currentPlace);
                    this.center = marker;
                    this.currentPlace = null;
                }
            },
            geolocate() {
                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                });
            },
            setMarkers(places) {
                this.markers = [];
                for (let item of places) {
                    const marker = JSON.parse(item.coordinates);
                    this.markers.push({ position: marker });
                }
            }
        }
    };
</script>