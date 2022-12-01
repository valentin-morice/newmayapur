<template>
    <form class="mb-1">
        <div class="flex gap-2">
            <select v-model="form.payment.currency" class="select select-bordered">
                <option value="null" disabled selected>Currency</option>
                <option :value="'EUR'">EUR</option>
                <option :value="'AUD'">AUD</option>
                <option :value="'GBP'">GBP</option>
                <option :value="'INR'">INR</option>
                <option :value="'NZD'">NZD</option>
            </select>
            <input type="text" v-model="form.payment.amount"
                   :class="errors.amount ? 'bg-red-200 placeholder-red-600' : ''"
                   :placeholder="errors.amount ? errors.amount : 'Amount'"
                   class="input input-bordered w-full max-w-xs">
        </div>
        <input type="text" v-model="form.firstname"
               :class="errors.firstname ? 'bg-red-200 placeholder-red-600' : ''"
               :placeholder="errors.firstname ? errors.firstname : 'First Name'"
               class="mt-4 input input-bordered w-full"/>
        <input type="text" v-model="form.lastname"
               :class="errors.lastname ? 'bg-red-200 placeholder-red-600' : ''"
               :placeholder="errors.lastname ? errors.lastname : 'Last Name'"
               class="mt-4 input input-bordered w-full"/>
        <input type="text" v-model="form.email"
               :class="errors.email ? 'bg-red-200 placeholder-red-600' : ''"
               :placeholder="errors.email ? errors.email : 'Email'"
               class="mt-4 input input-bordered w-full"/>
    </form>
</template>

<script>

export default {
    beforeUnmount() {
        if (Object.keys(this.errors).length === 0) {
            const vm = this
            fetch('/stripe/create-payment', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf,
                },
                body: JSON.stringify(this.form)
            })
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error();
                })
                .then((data) => {
                        vm.stripe_data.client_secret = data.client_secret
                        vm.stripe_data.stripe_pk = data.stripe_pk
                    }
                )
                .catch(function () {
                    vm.stripe_data.error = true
                });
        }
    },
    props: ['form', 'errors', 'stripe_data', 'csrf'],
}
</script>
