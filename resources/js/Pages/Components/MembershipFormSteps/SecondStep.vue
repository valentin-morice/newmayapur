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
                    <option :value="{ currency: 'EUR' }">EUR</option>
                    <option :value="{ currency: 'USD' }">USD</option>
                    <option :value="{ currency: 'GBP' }">GBP</option>
                </select>
                <input type="text" v-model="form.values.member.subscription.amount"
                       :class="errors.values.second.amount ? 'bg-red-200 placeholder-red-600' : ''"
                       :placeholder="errors.values.second.amount ? errors.values.second.amount : 'Amount'"
                       class="input input-bordered w-full max-w-xs">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['form', "errors"],
    watch: {
        'form.values.member.subscription.amount'(value) {
            if (value.length === null || value < 3 || value.includes(',')) {
                this.errors.values.second.amount = 'Enter a Valid Amount';
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
