<template>
    <div>
        <p class="pb-4">Contribution is <b>monthly</b>. Choose your amount:</p>
        <div class="flex justify-between gap-2">
            <PriceSelector v-for="amount in amounts" @click="setAmount(amount)"
                           :class="form.values.member.subscription.amount === amount ? 'bg-blue-100 border-blue-400' : 'border-gray-300'"
                           :amount="amount"
                           :selectedAmount="form.values.member.subscription.amount"
                           :currency="form.values.member.subscription.currency"/>
        </div>
        <select v-model="form.values.member.subscription.currency" class="select select-bordered w-full mt-5">
            <option value="" disabled selected>Choose your currency</option>
            <option value="EUR">EUR</option>
            <option value="USD">USD</option>
            <option value="AUD">AUD</option>
            <option value="NZD">NZD</option>
            <option value="INR">INR</option>
            <option value="GBP">GBP</option>
        </select>
        <select v-model="form.values.member.subscription.payment_method" class="select select-bordered w-full mt-5">
            <option value="" disabled selected>Choose your payment method</option>
            <option value="stripe">Credit Card</option>
            <option value="gocardless">Direct Debit</option>
        </select>
    </div>
</template>

<script>
import PriceSelector from "../UI/PriceSelector";

export default {
    props: ['form', "errors"],
    components: {
        PriceSelector
    },
    methods: {
        setAmount(amount) {
            this.form.values.member.subscription.amount = amount
        }
    },
    data() {
        return {
            amounts: [16, 32, 64, 108]
        }
    },
    watch: {
        'form.values.member.subscription.currency'(value) {
            if (value.length === '') {
                this.errors.values.second.currency = 1;
            } else {
                delete this.errors.values.second.currency
            }
        },
        'form.values.member.subscription.amount'(value) {
            if (value.length === '') {
                this.errors.values.second.amount = 1;
            } else {
                delete this.errors.values.second.amount
            }
        },
        'form.values.member.subscription.payment_method'(value) {
            if (value.length === '') {
                this.errors.values.second.payment_method = 1;
            } else {
                delete this.errors.values.second.payment_method
            }
        },
    }
}
</script>
