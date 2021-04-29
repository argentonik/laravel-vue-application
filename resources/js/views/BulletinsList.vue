<template>
    <div>
        <v-flex d-flex v-if="isLoaded">
            <v-layout wrap>
                <v-flex 
                    md4 
                    v-for="bulletin in allBulletins" 
                    :key="bulletin.id"
                >
                    <AppListCard 
                        class="ma-8"
                        :id="bulletin.id"
                        :imageSrc="bulletin.image"
                        :title="bulletin.title"
                        :description="bulletin.description"
                        :date="bulletin.date" />
                </v-flex>
            </v-layout>
        </v-flex>
        <v-layout v-else justify-center align-center>
            <AppSpinner  />
        </v-layout>

        <v-pagination
            v-if="isLoaded"
            v-model="pagination.current"
            :length="pagination.total"
            @input="onPageChange"
        ></v-pagination>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import AppListCard from '@/js/components/AppListCard'
    import AppSpinner from '@/js/components/AppSpinner'

    export default {
        computed: mapGetters([
            'allBulletins',
            'pagination',
            'isLoaded'
        ]),
        watch: {
            pagination() {
                window.scrollTo(0,0)
            }
        },
        methods: {
            ...mapActions(['fetchBulletins']),

            onPageChange() {
                this.fetchBulletins(this.pagination.current);
            }
        },
        mounted() {
            this.fetchBulletins()
        },
        components: {
            AppListCard, AppSpinner
        }
    }
</script>