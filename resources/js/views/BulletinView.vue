<template>
    <div>
        <AppDetailsCard 
            v-if="isLoaded" 
            :item="currentBulletin" 
        />
        <v-layout v-else justify-center align-center>
            <AppSpinner  />
        </v-layout>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import AppDetailsCard from '@/js/components/AppDetailsCard'
import AppSpinner from '@/js/components/AppSpinner'

export default {
    props: {
        id: {
            type: [String, Number],
            required: true
        }
    },
    computed: mapGetters([
        'currentBulletin',
        'isLoaded'
    ]),
    methods: {
        ...mapActions(['getById']),
    },
    mounted() {
        this.getById(this.id)
    },
    components: {
        AppDetailsCard, AppSpinner
    }
}
</script>