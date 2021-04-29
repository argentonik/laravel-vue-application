<template>
    <v-layout justify-center>
        <v-flex xs12 sm10 md6>
            <h1>Register</h1>
            <form 
                @submit.prevent="onRegister"
            >
                <v-text-field
                    v-model="name"
                    v-validate="'required|max:255'"
                    data-vv-name="name"
                    :error-messages="errors.collect('name')"
                    label="Name"
                    name="name"
                ></v-text-field>

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
                    ref="password"
                    label="Password"
                    name="password"
                    type="password"
                ></v-text-field>

                <v-text-field
                    v-model="password_confirmation"
                    v-validate="'required|confirmed:password'"
                    data-vv-as="password"
                    :error-messages="errors.collect('password_confirmation')"
                    label="Password Confirm"
                    name="password_confirmation"
                    type="password"
                ></v-text-field>

                <v-btn 
                    type="submit" 
                    color="primary"
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
                name : "",
                email : "",
                password : "",
                password_confirmation : ""
            }
        },
        methods: {
            ...mapActions(['register']),

            onRegister: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let data = {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        }
                        this.register(data)
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
        margin-top: 5%;
    }
    .v-btn {
        margin-top: 10px;
    }
</style>