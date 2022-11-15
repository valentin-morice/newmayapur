<template>
    <div>
        <ErrorNotification :error="errors.values.server"/>
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-2">Your Details</h2>
            <p>Review your details before confirming your payment.</p>
        </div>
        <div class="p-2 bg-gray-100 rounded">
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Name</span>
                <p>{{ form.values.member.firstname + ' ' + form.values.member.lastname }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Email</span>
                <p>{{ form.values.member.email }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">City</span>
                <p>{{ form.values.member.address.city }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Address</span>
                <p>{{ form.values.member.address.address }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">ZIP</span>
                <p>{{ form.values.member.address.postal_code }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">State</span>
                <p>{{ form.values.member.address.state }}</p>
            </div>
            <div class="flex justify-between text-xs mb-1">
                <span class="uppercase text-gray-600 font-bold">Country</span>
                <p>{{ form.values.member.address.country }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import ErrorNotification from "../UI/ErrorNotification";

export default {
    components: {ErrorNotification},
    props: ['form', 'errors'],
    mounted() {
        const vm = this
        fetch('/stripe/create-subscription', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': vm.form.values.utils.csrf,
            },
            body: JSON.stringify(vm.form.values),
        })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error();
            })
            .then((data) => {
                    vm.form.values.member.subscription.client_secret = data.client_secret
                }
            )
            .catch(function () {
                vm.errors.values.server = true;
            });
    }
}
</script>
