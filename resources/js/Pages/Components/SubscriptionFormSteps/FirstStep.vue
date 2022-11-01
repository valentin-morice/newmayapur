<template>
    <form class="mb-1">
        <input type="text" :class="error.firstname ? 'bg-red-200 placeholder-red-600' : ''"
               :placeholder="error.firstname ? error.firstname : 'First Name'" v-model="form.values.firstname"
               class="input input-bordered w-full"/>
        <input type="text" :class="error.lastname ? 'bg-red-200 placeholder-red-600' : ''"
               v-model="form.values.lastname" class="mt-4 input input-bordered w-full"
               :placeholder="error.lastname ? error.lastname : 'Last Name'"/>
        <input type="text" :class="error.email ? 'bg-red-200 placeholder-red-600' : ''"
               v-model="form.values.email"
               :placeholder="error.email ? error.email : 'Email' "
               class="mt-4 input input-bordered w-full"/>
    </form>
</template>

<script>
export default {
    props: ['form', 'error'],
    watch: {
        'form.values.email'(value) {
            this.validateEmail(value)
        },
        'form.values.firstname'(value) {
            if (/\s/.test(value) || value.length < 2) {
                this.error.firstname = 'Please enter a valid first name.'
            } else {
                delete this.error.firstname
            }
        },
        'form.values.lastname'(value) {
            if (/\s/.test(value) || value.length < 2) {
                this.error.lastname = 'Please enter a valid last name.'
            } else {
                delete this.error.lastname
            }
        }
    },
    methods: {
        validateEmail(email) {
            if (!email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )) {
                this.error.email = 'Please enter a valid email.'
            } else {
                delete this.error.email
            }
        },
    },
}
</script>
