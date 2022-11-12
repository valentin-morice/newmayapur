<template>
    <form class="mb-1">
        <div class="flex gap-2">
            <select v-model="currency" class="select select-bordered">
                <option disabled selected>Currency</option>
                <option :value="{ currency: 'EUR', autoDecimalDigit: true, precision: 2 }">EUR</option>
                <option :value="{ currency: 'USD', autoDecimalDigit: true, precision: 2 }">USD</option>
                <option :value="{ currency: 'GBP', autoDecimalDigit: true, precision: 2 }">GBP</option>
            </select>
            <CurrencyInput
                :options="currency"
                class="input input-bordered w-full"
                placeholder="Amount"
            />
        </div>
        <input type="text" placeholder="First Name" class="mt-4 input input-bordered w-full"/>
        <input type="text" placeholder="Last Name" class="mt-4 input input-bordered w-full"/>
        <input type="text" placeholder="Email" class="mt-4 input input-bordered w-full"/>
    </form>
</template>

<script>
import CurrencyInput from "../UI/CurrencyInput";

export default {
    components: {
        CurrencyInput
    },
    data() {
        return {
            currency: {currency: 'EUR', autoDecimalDigit: true, precision: 2}
        }
    }
}
</script>
