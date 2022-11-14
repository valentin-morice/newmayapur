<template>
    <div class="rounded-xl bg-white p-8 shadow-lg mx-auto" style="width: 620px">
        <FirstStep
            v-if="int === 0"
            :form="form"
            :errors="errors"
            :stripe_data="stripe"
        />
        <SecondStep
            v-if="int === 1 && stripe.client_secret || stripe.error"
            :stripe_data="stripe"
        />
        <button
            class="btn w-full flex items-center btn-primary mt-6"
            @click="next"
            v-if="int === 0"
        > Next &#187;
        </button>
    </div>
</template>

<script>
import FirstStep from "./DonationFormSteps/FirstStep";
import SecondStep from "./DonationFormSteps/SecondStep";

export default {
    components: {FirstStep, SecondStep},
    data() {
        return {
            form: {
                firstname: '',
                lastname: '',
                email: '',
                payment: {
                    currency: {currency: 'EUR', autoDecimalDigit: true, precision: 2},
                    amount: null,
                }
            },
            int: 0,
            active: true,
            errors: {
                firstname: '',
                lastname: '',
                email: '',
                amount: null,
            },
            stripe: {
                error: '',
                client_secret: '',
                stripe_pk: ''
            }
        }
    },
    methods: {
        async next() {
            if (this.int === 0) {
                if (Object.keys(this.errors).length !== 0) return
            }
            this.int++
        },
        validateEmail(email) {
            if (!email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )) {
                this.errors.email = 'Please enter a valid email.'
            } else {
                delete this.errors.email
            }
        },
    },
    watch: {
        'form.email'(value) {
            this.validateEmail(value)
        },
        'form.firstname'(value) {
            if (/\s/.test(value) || value.length < 2) {
                this.errors.firstname = 'Please enter a valid first name.'
            } else {
                delete this.errors.firstname
            }
        },
        'form.lastname'(value) {
            if (/\s/.test(value) || value.length < 2) {
                this.errors.lastname = 'Please enter a valid last name.'
            } else {
                delete this.errors.lastname
            }
        },
        'form.payment.amount'(value) {
            if (value.length === 0) {
                this.errors.amount = 1
            } else {
                delete this.errors.amount
            }
        }
    },
}
</script>
