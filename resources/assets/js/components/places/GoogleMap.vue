<template>
    <div>
        <div>
            <h2>Search and add a place</h2>
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
                :zoom="zoom"
                @click="addNewPlace($event)"
                style="width:100%;  height: 600px;"
        >
            <gmap-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :clickable="true"
                    @click="zoom=7; center=m.position"
                    @mousedown="m.visible=true"
            >
                <gmap-info-window  :opened="m.visible" @closeclick="m.visible=false">
                    Place Name: {{m.content.title}}<br>
                    The place is {{m.content.isVisited? '': 'not '}} visited.
                </gmap-info-window>
            </gmap-marker>

            <gmap-marker
                    v-if="newPlace"
                    :position="newPlace.position"
                    :clickable="true"
                    @click="center=newPlace.position"
            >
                <gmap-info-window  :opened="newPlace.visible" @closeclick="newPlace.visible=false">
                    Place Name: <input type="text" v-model="newPlace.content.title" placeholder="Enter name"><br>
                    The place is {{newPlace.content.isVisited? '': 'not '}} visited.
                    <button @click="saveNewPlace()">Save</button>
                </gmap-info-window>
            </gmap-marker>

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
                currentPlace: null,
                zoom: 2,
                newPlace: null
            };
        },

        mounted() {
            this.$bus.$on('setPlaces', (message) => {this.setMarkers(message.data)});
        },

        methods: {
            addNewPlace($event){
                this.newPlace = null;
                const marker = {
                    position: {
                        lat: $event.latLng.lat(),
                        lng: $event.latLng.lng()
                    },
                    content: {title: '',
                        isVisited: false},
                    type: 'event',
                    visible: true
                };
                this.newPlace = marker;
            },
            saveNewPlace(){
                this.$bus.$emit('placeAdded', {data: this.newPlace});
                this.markers.push(this.newPlace);
                this.newPlace = null;
            },
            // receives a place object via the autocomplete component
            setPlace(place) {
                this.currentPlace = place;
            },
            addMarker() {
                if (this.currentPlace) {
                    this.$bus.$emit('placeAdded', {data: this.currentPlace});
                    const marker = {
                        position: {
                          lat: this.currentPlace.geometry.location.lat(),
                          lng: this.currentPlace.geometry.location.lng()
                        },
                        content: {title: this.currentPlace.name,
                                  isVisited: false},
                        type: 'event',
                        visible: false
                    };
                    this.markers.push(marker);
                    this.places.push(this.currentPlace);
                    this.center = marker.position;
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
                    const marker = { position: JSON.parse(item.coordinates),
                                    content: {title: item.name,
                                              isVisited: (item.visited == 0)? false: true},
                                    type:'event',
                                    visible: false,
                                    id: item.id};
                    this.markers.push(marker);
                }
            },
            concentrate(marker){
                this.center=marker.position;
                this.zoom = 7;
            }
        }
    };
</script>