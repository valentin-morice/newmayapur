<template>
    <div class="rounded-2xl m-4 px-6 pt-4 pb-5 w-[340px] md:w-[600px] shadow-lg bg-white">
        <h2 class="font-bold text-xl text-gray-700">Export XLSX</h2>
        <div class="bg-base-200 rounded my-4 p-4 space-y-2">
            <select @change="reset" v-model="form.object" class="select select-bordered w-full">
                <option value="" disabled selected>Object</option>
                <option value="payments">Payments</option>
                <option value="members">Members</option>
            </select>
            <p v-if="error.object" class="text-sm text-red-500 ml-0.5">{{ error.object }}</p>
            <div v-if="form.object" class="pt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-7">
                    <Datepicker v-model="form.date.start" placeholder="Start Date"/>
                    <Datepicker v-model="form.date.end" placeholder="End Date"/>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select v-model="form.status" v-if="form.object === 'members' || !form.object"
                            class="select select-bordered w-full">
                        <option value="" disabled selected>Status</option>
                        <option value="active">Active</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <select v-model="form.status" v-else
                            class="select select-bordered w-full">
                        <option value="" disabled selected>Status</option>
                        <option v-for="status in payment_status" :value="status">
                            {{ capitalize(status) }}
                        </option>
                    </select>
                    <select v-model="form.currency" v-if="form.object === 'members' || !form.object"
                            class="select select-bordered w-full">
                        <option value="" disabled selected>Currency</option>
                        <option v-for="currency in currencies_members">{{ currency }}</option>
                    </select>
                    <select v-model="form.currency" v-else class="select select-bordered w-full">
                        <option value="" disabled selected>Currency</option>
                        <option v-for="currency in currencies_payments">{{ currency }}</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-8" :class="form.object ? 'pt-8' : 'pt-6'">
                <button @click="submit('filtered')" class="btn w-full btn-secondary">Export Filtered
                </button>
                <button @click="submit('all')" class="btn w-full btn-primary">Export All</button>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';

export default {
    components: {
        Datepicker
    },
    data() {
        return {
            form: {
                date: {
                    start: null,
                    end: null,
                },
                object: '',
                currency: '',
                status: '',
            },
            error: {
                object: null
            }
        };
    },
    props: ['currencies_members', 'payment_status', 'currencies_payments'],
    methods: {
        submit(items) {
            if (items === 'all') {
                if (this.form.object === '') {
                    this.error.object = 'Please chose a value.'
                    return
                } else this.error.object = ''
                let params = {
                    filtered: false,
                    object: this.form.object
                };
                let paramString = new URLSearchParams(params);
                window.open(`/admin/export/store?${paramString.toString()}`);
                this.reset()
            } else if (items === 'filtered') {
                if (this.form.object === '') {
                    this.error.object = 'Please chose a value.'
                    return
                }
                let params = {
                    filtered: true,
                    date_start: this.form.date.start,
                    date_end: this.form.date.end,
                    currency: this.form.currency,
                    status: this.form.status,
                    object: this.form.object
                };
                let paramString = new URLSearchParams(params);
                window.open(`/admin/export/store?${paramString.toString()}`);
                this.reset()
            }
        },
        capitalize(string) {
            const arr = string.replaceAll('_', ' ').split(' ')
            for (let i = 0; i < arr.length; i++) {
                arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
            }
            return arr.join(" ")
        },
        reset() {
            this.form.currency = ''
            this.form.status = ''
            this.error.object = ''
            this.form.date.start = null
            this.form.date.end = null
        }
    }
}
</script>

<style lang="scss">
$dp__border_radius: 8px !default;
$dp__input_padding: 10px 12px !default;
@import "node_modules/@vuepic/vue-datepicker/src/VueDatePicker/style/main.scss";
</style>
