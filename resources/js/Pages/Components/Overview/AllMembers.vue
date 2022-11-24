<template>
    <div class="rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
        <h2 class="font-bold text-xl text-gray-700">Members</h2>
        <div class="flex gap-2">
            <div class="p-2 w-1/2 my-4 flex bg-gray-100 rounded justify-between">
                <span class="uppercase font-bold">Active</span>
                <span>{{ active }}</span>
            </div>
            <div class="p-2 w-1/2 my-4 flex bg-gray-100 rounded justify-between">
                <span class="uppercase font-bold">Cancelled</span>
                <span>{{ cancelled }}</span>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2">
            <div v-for="members in members"
                 class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                <CountryFlag :country='Object.keys(members)[0]' :rounded="true" size='normal'/>
                <p>{{ Object.values(members)[0] }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import CountryFlag from "vue-country-flag-next";

export default {
    props: ['members', 'active', 'cancelled'],
    components: {
        CountryFlag
    }
}
</script>

<style scoped>
.normal-flag {
    margin: 0 0 0 -12px !important;
}
</style>
