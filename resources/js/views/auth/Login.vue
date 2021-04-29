<template>
    <v-layout justify-center>
        <v-flex xs12 sm10 md6>
            <form 
                class="login" 
                method="POST" 
                @submit.prevent="onLogin"
            >
                <h1>Log in</h1>

                <v-text-field
                    v-model="email"
                    v-validate="'required|email|max:255'"
                    data-vv-name="email"
                    :error-messages="errors.collect('email')"
                    label="Email"
                    name="email"
                ></v-text-field>

                <v-text-field
                    v-model="password"
                    v-validate="'required|min:8'"
                    data-vv-name="password"
                    :error-messages="errors.collect('password')"
                    label="Password"
                    name="password"
                    type="password"
                ></v-text-field>

                <v-btn 
                    color="primary" 
                    type="submit"
                >Submit</v-btn>
            </form>
        </v-flex>
    </v-layout>
</template>

<script>
import { mapActions} from 'vuex'

export default {
    inject: ['$validator'],
    data() {
        return {
            email : "",
            password : ""
        }
    },
    methods: {
        ...mapActions(['login']),

        onLogin: function () {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let email = this.email 
                    let password = this.password
                    let _token = this.csrf_token
                    this.login({ _token, email, password })
                        .then(() => this.$router.push('/'))
                        .catch(err => console.log(err))
                }
            })
        }
    }
}
</script>

<style scoped>
    .layout {
        margin-top: 10%;
    }
    .v-btn {
        margin-top: 10px;
    }
</style>