<template>
    <div>
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-2">Your Details</h2>
            <p>Review your details before confirming your payment.</p>
        </div>
        <div class="p-2 bg-gray-100 rounded">
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Name</span>
                <p>{{ form.values.firstname + ' ' + form.values.lastname }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Email</span>
                <p>{{ form.values.email }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">City</span>
                <p>{{ form.values.city }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Address</span>
                <p>{{ form.values.address }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">ZIP</span>
                <p>{{ form.values.postalcode }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">State</span>
                <p>{{ form.values.state }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Country</span>
                <p>{{ form.values.country }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['form'],
    mounted() {
        const vm = this
        fetch('/stripe/create-subscription', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': vm.form.values.csrf,
            },
            body: JSON.stringify(vm.form.values),
        }).then(
            ((response) => response.json())
        ).then((data) => {
                console.log(data)
                vm.form.values.clientSecret = data.clientSecret
            }
        )
    }
}
</script>
