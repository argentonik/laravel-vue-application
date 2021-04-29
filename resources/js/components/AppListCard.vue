<template>
    <v-card
        class="bulletin-card"
    >
        <v-img
            :src="imageSrc"
        ></v-img>

        <v-card-title>
            <router-link :to="{name: 'bulletin-view', params: {id: parseInt(id)}}">{{ title }}</router-link>
        </v-card-title>

        <v-card-subtitle>
            {{ description }}
            <hr>
            <p class="date">{{ date }}</p>
        </v-card-subtitle>
    </v-card>
</template>

<script>
export default {
    props: {
        id: {
            type: Number,
            required: true
        },
        imageSrc: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: true
        },
        date: {
            type: String,
            required: true
        }
    },
    methods: {
        show: function(event) {
            targetId = event.currentTarget.id;
        }
    },
}
</script>

<style scoped>
    .date {
        color: #BDBDBD;
    }
</style>