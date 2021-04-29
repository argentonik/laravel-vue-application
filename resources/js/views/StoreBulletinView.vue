<template>
    <div>
        <v-card
            class="mx-auto store-card"
            max-width="50%"
            v-if="!id || isLoaded"
        >
            <form 
                method="POST" 
                @submit.prevent="onSubmit" 
                enctype="multipart/form-data"
            >
                <AppUploadImage 
                    v-if="id"
                    :serverImage="image"
                    @changeImage="setImage" />
                <AppUploadImage
                    v-else
                    @changeImage="setImage" 
                />
                
                <v-text-field
                    v-model="title"
                    v-validate="'required|min:4|max:64'"
                    data-vv-name="title"
                    :error-messages="errors.collect('title')"
                    label="Title"
                    name="title"
                ></v-text-field>

                <v-textarea
                    v-model="description"
                    v-validate="'required|min:4|max:512'"
                    data-vv-name="description"
                    :error-messages="errors.collect('description')"
                    label="Description"
                    name="description"
                    rows="3"
                ></v-textarea>

                <v-text-field
                    v-model="phone"
                    v-validate="'required|min:17'"
                    v-mask="['+1 (###) ###-####']"
                    data-vv-name="phone"
                    :error-messages="errors.collect('phone')"
                    label="Phone"
                    name="phone">
                </v-text-field> 

                <v-text-field
                    v-model="country"
                    v-validate="'required|min:2|max:32'"
                    data-vv-name="country"
                    :error-messages="errors.collect('country')"
                    label="Country"
                    name="country"
                ></v-text-field>

                <v-text-field
                    v-model="email"
                    v-validate="'required|email'"
                    data-vv-name="email"
                    :error-messages="errors.collect('email')"
                    label="Email"
                    name="email"
                ></v-text-field>

                 <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    :return-value.sync="date"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date"
                        label="Valid to"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                    </template>
                    <v-date-picker 
                        v-model="date" 
                        no-title 
                        scrollable
                        color="#005caf"
                        :min="minDate()"
                        :max="maxDate()"
                    >
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                    </v-date-picker>
                </v-menu>

                <AppGoogleMap
                    :isEdit="true" 
                    :latitude="latitude"
                    :longitude="longitude"
                    @changeCoordinates="setCoordinates" />

                <div class="d-flex flex-row justify-space-between">
                    <p></p>
                    <v-btn 
                        color="primary" 
                        type="submit"
                    >Submit</v-btn>
                </div>
            </form>
        </v-card>
        <v-layout v-else justify-center align-center>
            <AppSpinner  />
        </v-layout>
    </div>
</template>

<script>
import { mapActions, mapGetters} from 'vuex'
import {mask} from 'vue-the-mask'

import AppGoogleMap from '@/js/components/AppGoogleMap'
import AppUploadImage from '@/js/components/AppUploadImage'
import AppSpinner from '@/js/components/AppSpinner'

export default {
    inject: ['$validator'],
    components: {
        AppGoogleMap, AppUploadImage, AppSpinner
    },
    directives: {
        mask
    },
    props: {
        id: {
            type: [String, Number],
            required: false
        }
    },
    data() {
        return {
            title: '',
            description: '',
            phone: '',
            country: '',
            email: '',
            latitude: null,
            longitude: null,
            date: this.minDate(),
            image: '',

            menu: false,
            modal: false,
            menu2: false
        }
    },
    computed: {
         ...mapGetters(['currentBulletin', 'isLoaded']),
    },
    watch: {
        currentBulletin() {
            this.title = this.currentBulletin.title
            this.description = this.currentBulletin.description
            this.phone = this.currentBulletin.phone
            this.country = this.currentBulletin.country
            this.email = this.currentBulletin.email
            this.date = this.currentBulletin.valid_to
            this.latitude = this.currentBulletin.latitude
            this.longitude = this.currentBulletin.longitude
            this.image = this.currentBulletin.image
        },
    },
    mounted() {
        if (this.id) {
            this.getById(this.id)
        }
    },
    methods: {
        ...mapActions(['createBulletin', 'updateBulletin', 'getById']),

        setCoordinates(coordinates) {
            this.latitude = coordinates.latitude
            this.longitude = coordinates.longitude
        },

        setImage(image) {
            this.image = image
        },

        onSubmit() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let formData = new FormData()
                    formData.append('title', this.title)
                    formData.append('description', this.description)
                    formData.append('phone', this.phone)
                    formData.append('country', this.country)
                    formData.append('email', this.email)
                    formData.append('valid_to', this.date)
                    formData.append('image', this.image)
                    formData.append('latitude', this.latitude)
                    formData.append('longitude', this.longitude)

                    if (this.id) {
                        formData.append('id', this.id)
                        this.updateBulletin(formData).then(() => this.$router.push('/bulletins/' + this.id))
                    } else {
                        this.createBulletin(formData).then(() => this.$router.push('/bulletins/' + this.currentBulletin.id))
                    }
                }
            });
        },
        minDate() {
            var today = new Date()
            var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000))
            return tomorrow.toISOString().substr(0, 10)
        },
        maxDate() {
            var today = new Date()
            var tomorrow = new Date(today.getTime() + (30 * 24 * 60 * 60 * 1000))
            return tomorrow.toISOString().substr(0, 10)
        }
    }
}
</script>

<style scoped>
    .store-card {
        padding: 30px;
    }
    .v-btn {
        outline: none !important;
    }
    .v-messages__message {
        margin-top: -45px;
    }
</style>