<template>
    <form style="margin-bottom: 0px">
        <select v-model="form.values.priceId" class="select select-bordered w-full"
                :class="error.city ? 'bg-red-200' : ''">
            <option disabled value="">Select Your Plan</option>
            <option v-for="product in products" :value="product[0]">
                {{ product[1] }} - €{{ product[2] }}
            </option>
        </select>
    </form>
</template>

<script>
export default {
    props: ['form', 'error'],
    data() {
        return {
            products: null,
        }
    },
    beforeCreate() {
        const vm = this
        fetch('/create-customer', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(vm.form.values)
        })
            .then((response) => response.json())
            .then((data) => {
                vm.form.values.customerId = data.customerId
                vm.products = data.products
            })
    },
    watch: {
        'form.values.priceId'(value) {
            if (value.length === 0) {
                this.error.priceId = 1
            } else {
                delete this.error.priceId
            }
        },
    }
}
</script>
