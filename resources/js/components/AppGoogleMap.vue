<template>
    <div>
        <div 
            class="google-map" 
            id="map"
        ></div>
    </div>
</template>

<script>
import { Loader } from 'google-maps'

export default {
    props: {
        isEdit: {
            type: Boolean,
            required: true
        },
        latitude: {
            type: String,
            required: false,
            default: null
        },
        longitude: {
            type: String,
            required: false,
            default: null
        }
    },
    data() {
        return {
            map: null,
            coordinates: {
                latitude: null,
                longitude: null
            }
        }
    },
    components: {
        Loader
    },
    mounted() {
        this.initMap(this)
    },
    watch: {
        coordinates(val) {
            this.$emit('changeCoordinates', val)
        }
    },
    methods: {
        initMap: function(context) {
            let coordinates = {
                lat: 50.4500336, lng: 30.5241361
            }

            let mapOptions = {
                zoom: 12, 
                center: coordinates,
                draggableCursor: 'default'
            }

            if (JSON.parse(this.latitude) && JSON.parse(this.longitude)) {
                //if is coordinates from server set it to map
                coordinates.lat = Number.parseFloat(this.latitude);
                coordinates.lng = Number.parseFloat(this.longitude);
            }

            this.map = new google.maps.Map(
                document.getElementById('map'), mapOptions);

            if (this.isEdit) {
                google.maps.event.addListener(this.map, 'click', function(e) {
                    if ( !marker ) {
                        marker = new google.maps.Marker({ map: this.map });
                    }
                    marker.setPosition(e.latLng);
                    context.coordinates= {
                        latitude: e.latLng.lat().toFixed(7),
                        longitude: e.latLng.lng().toFixed(7)
                    }
                });
            }
            let marker = new google.maps.Marker({position: coordinates, map: this.map});
        },
        show(event) {
            targetId = event.currentTarget.id;
        }
    }
}
</script>

<style scoped>
    .google-map {
        height: 20rem;
        width: 100%;
        margin-top: -10px;
        margin-bottom: 10px;
    }
</style>



