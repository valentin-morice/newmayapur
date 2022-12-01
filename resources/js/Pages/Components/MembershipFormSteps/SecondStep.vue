<template>
    <div>
        <p class="px-4 py-2 bg-blue-100 rounded-[8px]">Contribution is <b>monthly</b>.</p>
        <select v-model="form.values.member.subscription.payment_method" class="select select-bordered w-full mt-4">
            <option value="" disabled selected>Choose your payment method</option>
            <option value="stripe">Credit Card</option>
            <option value="gocardless">Direct Debit</option>
        </select>
        <div class="flex justify-between mt-4 gap-2">
            <div class="flex gap-2">
                <select v-model="form.values.member.subscription.currency" class="select select-bordered">
                    <option disabled selected>Currency</option>
                    <option :value="{ currency: 'EUR', autoDecimalDigit: true, precision: 2 }">EUR</option>
                    <option :value="{ currency: 'AUD', autoDecimalDigit: true, precision: 2 }">AUD</option>
                    <option :value="{ currency: 'NZD', autoDecimalDigit: true, precision: 2 }">NZD</option>
                    <option :value="{ currency: 'GBP', autoDecimalDigit: true, precision: 2 }">GBP</option>
                </select>
                <CurrencyInput
                    :options="form.values.member.subscription.currency"
                    class="input input-bordered w-full"
                    placeholder="Amount"
                    v-model="form.values.member.subscription.amount"
                />
            </div>
        </div>
    </div>
</template>

<script>
import CurrencyInput from "../UI/CurrencyInput";

export default {
    props: ['form', "errors"],
    components: {
        CurrencyInput
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
        'form.values.member.subscription.amount'(value) {
            if (value.length === '' || value < 3) {
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
