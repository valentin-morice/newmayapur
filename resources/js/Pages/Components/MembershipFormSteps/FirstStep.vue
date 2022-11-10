<template>
    <form class="mb-1">
        <input type="text" :class="errors.values.first.firstname ? 'bg-red-200 placeholder-red-600' : ''"
               :placeholder="errors.values.first.firstname ? errors.values.first.firstname : 'First Name'"
               v-model="form.values.member.firstname"
               class="input input-bordered w-full"/>
        <input type="text" :class="errors.values.first.lastname ? 'bg-red-200 placeholder-red-600' : ''"
               v-model="form.values.member.lastname" class="mt-4 input input-bordered w-full"
               :placeholder="errors.values.first.lastname ? errors.values.first.lastname : 'Last Name'"/>
        <input type="text" :class="errors.values.first.email ? 'bg-red-200 placeholder-red-600' : ''"
               v-model="form.values.member.email"
               :placeholder="errors.values.first.email ? errors.values.first.email : 'Email' "
               class="mt-4 input input-bordered w-full"/>
    </form>
</template>

<script>
export default {
    props: ['form', 'errors'],
    watch: {
        'form.values.member.email'(value) {
            this.validateEmail(value)
        },
        'form.values.member.firstname'(value) {
            if (/\s/.test(value) || value.length < 2) {
                this.errors.values.first.firstname = 'Please enter a valid first name.'
            } else {
                delete this.errors.values.first.firstname
            }
        },
        'form.values.member.lastname'(value) {
            if (/\s/.test(value) || value.length < 2) {
                this.errors.values.first.lastname = 'Please enter a valid last name.'
            } else {
                delete this.errors.values.first.lastname
            }
        }
    },
    methods: {
        validateEmail(email) {
            if (!email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )) {
                this.errors.values.first.email = 'Please enter a valid email.'
            } else {
                delete this.errors.values.first.email
            }
        },
    },
}
</script>
