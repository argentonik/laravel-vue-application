<template>
    <div>
        <v-navigation-drawer 
            app
            v-model="drawer"
            class="blue darken-3"
            dark>
                <v-list-item  
                    v-if="!isLoggedIn" 
                    two-line
                >
                    <v-list-item-content>
                        <v-list-item-title>Hello, guest!</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <div v-else >
                    <v-list-item two-line>
                        <v-list-item-avatar>
                            <v-icon>mdi-account</v-icon>
                        </v-list-item-avatar>

                        <v-list-item-content >
                            <v-list-item-title>{{ currentUserName }}</v-list-item-title>
                            <v-list-item-subtitle>Logged In</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item 
                        one-line 
                        :to="{name: 'bulletin-create'}"
                    >
                        <v-list-item-icon>
                            <v-icon>mdi-plus</v-icon>
                        </v-list-item-icon>
                        
                        <v-list-item-content >
                            <v-list-item-title> Create new</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </div>

                <v-list v-if="!isLoggedIn">  
                    <v-list-item
                        v-for="item in notLogin"
                        :key="item.title"
                        :to="{name: item.link}"
                        link
                    >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <template 
                    v-if="isLoggedIn" 
                    #append
                >
                    <v-list-item @click="onLogout">
                        <v-list-item-icon>
                            <v-icon>mdi-exit-to-app</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Log out</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
        </v-navigation-drawer>

        <v-app-bar
            app
            class="blue darken-3"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title><router-link :to="{name: 'home'}">Bulletins board</router-link></v-toolbar-title>
        </v-app-bar>
    </div>
</template>

<script>
import { mapGetters,  mapActions} from 'vuex'

    export default {
        computed: mapGetters([
            'isLoggedIn', 'currentUserName'
        ]),
        data() {
            return {
                notLogin: [
                    {
                        icon: 'mdi-account-box',
                        title: 'Log in', 
                        link: 'login'
                    },
                    {
                        icon: 'mdi-account-plus',
                        title: 'Register', 
                        link: 'register'
                    }
                ],
                drawer: null,
            }
        },
        methods: {
            ...mapActions(['logout']),

            onLogout() {
                this.logout().then(() => {
                    if (this.$route.path !== '/') {
                        this.$router.push('/')
                    }
                })
            }
        }
    }
</script>

<style scoped>
    a:hover {
        text-decoration: none;
    }
    .v-application a {
        color: white;
    }
</style>