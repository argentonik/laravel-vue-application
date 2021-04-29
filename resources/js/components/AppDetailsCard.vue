<template>
    <v-card
        class="mx-auto details-card"
        max-width="50%"
        v-if="item"
    >
        <v-img
            :src="item.image"
            height="auto">
        </v-img>

        <v-card-title>
            {{ item.title }}
        </v-card-title>

        <v-card-subtitle>
            <p>{{ item.description }}</p>
            <p><b>Phone:</b> {{ item.phone }}</p>
            <p><b>Country:</b> {{ item.country}}</p>
            <p><b>Email:</b> {{ item.email}}</p>
            <AppGoogleMap 
                :isEdit="false" 
                :latitude="item.latitude" 
                :longitude="item.longitude" 
            />
            <hr>
            <div class="d-flex flex-row justify-space-between">
                <p class="date">{{ item.date }}</p>
                <v-btn 
                    color="primary" 
                    :to="{name: 'bulletin-edit', params: {id: item.id}}"
                    v-if="canEdit()"
                >Edit</v-btn>
            </div>
        </v-card-subtitle>
    </v-card>
</template>

<script>
import AppGoogleMap from '@/js/components/AppGoogleMap'
import { mapGetters } from 'vuex'

export default {
    props: {
        item: {
            required: true
        }
    },
    components: {
        AppGoogleMap
    },
    computed: mapGetters([
        'currentUserId'
    ]),
    methods: {
        show(event) {
            targetId = event.currentTarget.id;
        },

        canEdit() {
            return this.item.user_id == this.currentUserId
        }
    }
}
</script>

<style scoped>  
    .details-card {
        margin-bottom: 20px;
    }
    .date {
        color: #BDBDBD;
    }
</style>