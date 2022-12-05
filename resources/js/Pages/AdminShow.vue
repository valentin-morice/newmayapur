<template>
    <Admin>
        <div class="flex flex-col lg:flex-row pt-3 px-6 items-baseline gap-6">
            <h1 class="font-bold text-3xl text-gray-700">{{ member.name }}</h1>
            <div class="flex bg-white inline-block py-3 px-5 rounded-xl shadow-sm items-center">
                <ion-icon name="mail-outline" class="text-2xl mr-2"></ion-icon>
                <p>{{ member.email }}</p>
            </div>
        </div>
        <div class="calculate rounded-2xl m-4 p-6 shadow-lg bg-white">
            <div class="grid grid-cols-1 w-[340px] md:w-[500px] lg:w-full lg:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <h2 class="font-bold text-xl text-gray-700">Subscription</h2>
                    <div class="bg-base-200 rounded my-4 p-4 space-y-2">
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">Amount</p>
                            <p class="text-sm text-gray-600">
                                <b>{{ getCurrency(member.subscription.currency) }}</b> {{ member.subscription.amount }}
                            </p>
                        </div>
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">Started</p>
                            <p class="text-sm text-gray-600">{{ member.subscription.date }}</p>
                        </div>
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">Status</p>
                            <p class="text-sm text-gray-600">{{ member.subscription.status }}</p>
                        </div>
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">Payment Method</p>
                            <p class="text-sm text-gray-600">{{ member.subscription.payment_method }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-700">Address</h2>
                    <div class="bg-base-200 rounded my-4 p-4 space-y-2">
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">Street</p>
                            <p class="text-sm text-gray-600">
                                {{ member.address.street }}
                            </p>
                        </div>
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">Postal Code</p>
                            <p class="text-sm text-gray-600">{{ member.address.postal_code }}</p>
                        </div>
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">City</p>
                            <p class="text-sm text-gray-600">{{ member.address.city }}</p>
                        </div>
                        <div class="items-center flex justify-between">
                            <p class="uppercase font-bold text-sm text-gray-600">Country</p>
                            <p class="text-sm text-gray-600">{{ member.address.country }}</p>
                        </div>
                    </div>
                </div>
                <a :href="url + '/' + member.customer_id" class="btn btn-primary" target="_blank">View in
                    {{ member.subscription.payment_method }}
                </a>
                <Link
                    v-if="member.subscription.payment_method !== 'Paypal' && member.subscription.payment_method !== 'Banque Postale'"
                    :class="member.subscription.status !== 'Cancelled' ? 'bg-red-600 hover:bg-red-600' : 'btn-disabled'"
                    class="btn border-0" method="put" :data="{object: 'cancel'}" as="button"
                    :href="'/' + member.subscription.payment_method.toLowerCase() + '/' + member.id">
                    Cancel Subscription
                </Link>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from "./Layout/Admin";
import getSymbolFromCurrency from 'currency-symbol-map'
import {Link} from "@inertiajs/inertia-vue3";


export default {
    components: {
        Admin,
        Link,
    },
    props: ['member', 'url'],
    methods: {
        getCurrency(code) {
            return getSymbolFromCurrency(code);
        }
    }
}
</script>
