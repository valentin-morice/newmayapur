<template>
    <Admin>
        <h1 class="font-bold text-3xl text-gray-700 pt-3 px-6">Export</h1>
        <div class="rounded-2xl m-4 p-6 pb-7 shadow-lg bg-white">
            <div class="bg-base-200 rounded my-4 p-4 space-y-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-6">
                    <Datepicker placeholder="Start Date"/>
                    <Datepicker v-model="date" placeholder="End Date"/>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-6">
                    <select class="select select-bordered w-full">
                        <option disabled selected>Status</option>
                        <option>Active</option>
                        <option>Cancelled</option>
                    </select>
                    <select class="select select-bordered w-full">
                        <option disabled selected>Currency</option>
                        <option>USD</option>
                        <option>EUR</option>
                    </select>
                </div>
                <select class="select select-bordered w-full">
                    <option disabled selected>Object</option>
                    <option>Payments</option>
                    <option>Members</option>
                </select>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-8">
                    <button class="btn w-full inline-block btn-secondary">Export Filtered</button>
                    <button class="btn w-full inline-block btn-primary">Export All</button>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from "./Layout/Admin";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    components: {
        Admin,
        Datepicker
    },
    data() {
        return {
            date: null,
        };
    }
}
</script>
