<template>
    <div class="mt-4 rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
        <h2 class="font-bold text-xl text-gray-700">Subscriptions</h2>
        <div class="p-2 my-4 flex bg-gray-100 rounded justify-between">
            <p><span class="uppercase font-bold">Total</span> /month</p>
            <span><b>€ </b>{{ (Math.round(subscriptions.total * 100) / 100).toFixed(2) }}</span>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div v-for="subscription in subscriptions.all"
                 class="rounded-xl px-5 py-4 flex items-center bg-gray-100 justify-between">
                <p class="font-bold uppercase">{{ Object.keys(subscription)[0] }}</p>
                <p>{{ (Math.round(Object.values(subscription)[0] * 100) / 100).toFixed(2) }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['subscriptions']
}
</script>
