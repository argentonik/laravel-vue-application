<template>
    <v-app>
        <AppMainNavigation />
        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    import AppMainNavigation from '@/js/components/AppMainNavigation';
    import { Loader } from 'google-maps'

    export default {
        components: {
            AppMainNavigation
        },
        mounted() {
            const loader = new Loader('AIzaSyCImHowMV88Ou6POksj4J5s0zrp2lu_K5M')
            loader.load()
        },
    }
</script>

<style  scoped>
    .container {
        height: 100%;
    }
</style>