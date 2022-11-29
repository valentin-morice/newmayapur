<template>
    <div class="bg-base-200 h-[750px] flex justify-center items-center px-2 lg:px-0 py-8">
        <div
            class="bg-white shadow-lg max-w-md md:w-[600px] mx-auto p-4 rounded-xl"
        >
            <ion-icon
                class="mx-auto block py-2 text-6xl text-gray-700"
                :name="
                    data.status === 'succeeded' || data.status === 'processing'
                        ? 'checkmark-circle-outline'
                        : 'close-circle-outline'
                "
            ></ion-icon>
            <h1 class="text-center pt-3 font-bold text-xl text-gray-700 mb-2">
                Payment Successful
            </h1>
            <p class="text-center" v-if="data.status === 'succeeded'">
                Great! Payment received.
            </p>
            <p class="text-center" v-else-if="data.status === 'processing'">
                Payment processing. We'll update you when the payment is
                received.
            </p>
            <p
                class="text-center"
                v-else-if="data.status === 'requires_payment_method'"
            >
                Payment failed. Please try another payment method.
            </p>
            <p class="text-center" v-else>Something went wrong.</p>
            <div class="bg-gray-100">
                <div
                    class="items-center flex justify-between px-3 pt-2 mt-8 border-t"
                >
                    <p class="text-sm text-gray-600">Amount</p>
                    <p class="text-sm text-gray-600">
                        <b>{{ data.currency.toUpperCase() }}</b> {{ (Math.round(data.amount * 100) / 100).toFixed(2) }}
                    </p>
                </div>
                <div class="items-center flex justify-between px-3 mt-3">
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="text-sm text-gray-600">{{ data.customer }}</p>
                </div>
                <div class="items-center flex justify-between px-3 mt-3 pb-3">
                    <p class="text-sm text-gray-600">Payment ID</p>
                    <p class="text-sm text-gray-600">{{ data.paymentId }}</p>
                </div>
            </div>
            <Link href="/">
                <button
                    class="bg-blue-500 w-full mt-8 block hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    Go Back
                </button>
            </Link>
        </div>
    </div>
</template>

<script>
import Base from "./Layout/Base";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    layout: Base,
    props: ["data"],
    components: {
        Link,
    },
};
</script>
