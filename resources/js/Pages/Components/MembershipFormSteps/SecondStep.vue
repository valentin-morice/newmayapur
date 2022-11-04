<template>
    <div>
        <p class="pb-4">Contribution is <b>monthly</b>. Choose your amount:</p>
        <div class="flex justify-between gap-2">
            <PriceSelector v-for="amount in amounts" @click="setAmount(amount)"
                           :class="form.values.amount === amount ? 'bg-blue-100 border-blue-400' : 'border-gray-300'"
                           :amount="amount"
                           :selectedAmount="form.values.amount"
                           :currency="form.values.currency"/>
        </div>
        <select v-model="form.values.currency" class="select select-bordered w-full mt-5">
            <option value="" disabled selected>Choose your currency</option>
            <option value="EUR">EUR</option>
            <option value="USD">USD</option>
            <option value="AUD">AUD</option>
            <option value="NZD">NZD</option>
            <option value="INR">INR</option>
            <option value="GBP">GBP</option>
        </select>
        <select v-model="form.values.paymentMethod" class="select select-bordered w-full mt-5">
            <option value="" disabled selected>Choose your payment method</option>
            <option value="stripe">Credit Card</option>
            <option value="gocardless">Direct Debit</option>
        </select>
        <input type="hidden" name="_token" :value="csrf">
    </div>
</template>

<script>
import PriceSelector from "../UI/PriceSelector";

export default {
    props: ['form', 'error'],
    components: {
        PriceSelector
    },
    methods: {
        setAmount(amount) {
            this.form.values.amount = amount
        }
    },
    data() {
        return {
            amounts: [16, 32, 64, 108]
        }
    },
    watch: {
        'form.values.currency'(value) {
            if (value.length === '') {
                this.error.currency = 1;
            } else {
                delete this.error.currency
            }
        },
        'form.values.amount'(value) {
            if (value.length === '') {
                this.error.amount = 1;
            } else {
                delete this.error.amount
            }
        },
        'form.values.paymentMethod'(value) {
            if (value.length === '') {
                this.error.paymentMethod = 1;
            } else {
                delete this.error.paymentMethod
            }
        },
    }
}
</script>
