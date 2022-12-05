<template>
    <div class="rounded-2xl m-4 px-6 pt-4 pb-8 w-[340px] md:w-[600px] shadow-lg bg-white">
        <h2 class="font-bold text-xl text-gray-700 mb-4">Create Offline Member</h2>
        <form @submit.prevent="submit" class="bg-base-200 rounded my-4 p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <input v-model="form.name" type="text" placeholder="Name" class="input input-bordered w-full">
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.name">{{ form.errors.name }}</p>
                </div>
                <div>
                    <input v-model="form.email" type="text" placeholder="Email" class="input input-bordered w-full">
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.email">{{ form.errors.email }}</p>
                </div>
            </div>
            <input v-model="form.address" type="text" placeholder="Address" class="mt-6 input input-bordered w-full">
            <p class="text-sm text-red-500 mt-2" v-if="form.errors.address">{{ form.errors.address }}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-6 mt-6">
                <div>
                    <input v-model="form.city" type="text" placeholder="City" class="input input-bordered w-full">
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.postal_code">Field Required.</p>
                </div>
                <div>
                    <input v-model="form.postal_code" type="text" placeholder="Postal Code"
                           class="input input-bordered w-full">
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.city">Field Required.</p>
                </div>
                <div>
                    <input v-model="form.state" type="text" placeholder="State" class="input input-bordered w-full">
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.state">Field Required.</p>
                </div>
                <div>
                    <select v-model="form.country" class="select select-bordered w-full">
                        <option value="" disabled selected>Country</option>
                        <option v-for="country in countries" value="country.code">{{ country.country }}</option>
                    </select>
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.country">Field Required.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 mt-6 gap-2">
                <div>
                    <input v-model="form.amount" type="text" placeholder="Amount" class="input input-bordered w-full">
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.amount">{{ form.errors.amount }}</p>
                </div>
                <div>
                    <select v-model="form.currency" class="select select-bordered w-full">
                        <option value="" disabled selected>Currency</option>
                        <option value="EUR">EUR</option>
                        <option value="AUD">AUD</option>
                        <option value="GBP">GBP</option>
                        <option value="NZD">NZD</option>
                    </select>
                    <p class="text-sm text-red-500 mt-2" v-if="form.errors.currency">Field Required.</p>
                </div>
            </div>
            <div class="mt-6">
                <select v-model="form.payment_method" class="select select-bordered w-full">
                    <option value="" disabled selected>Payment Method</option>
                    <option value="wise">Wise</option>
                    <option value="banque_postale">Banque Postale</option>
                    <option value="paypal">PayPal</option>
                </select>
                <p class="text-sm text-red-500 mt-2" v-if="form.errors.payment_method">Field Required.</p>
            </div>
            <button class="w-full btn btn-secondary mt-8">Add Member</button>
        </form>
        <div v-if="success" class="alert alert-success rounded-xl">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>The member has been added successfully.</span>
            </div>
        </div>
    </div>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    methods: {
        submit() {
            this.form.post('/offline/create', {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset()
                    this.success = true
                },
            })
        },
    },
    data() {
        return {
            form: useForm({
                name: '',
                email: '',
                address: '',
                city: '',
                postal_code: '',
                state: '',
                country: '',
                amount: '',
                currency: '',
                payment_method: '',
            }),
            countries: [
                {country: 'Argentina', code: 'AR'},
                {country: 'Australia', code: 'AU'},
                {country: 'Austria', code: 'AT'},
                {country: 'Belgium', code: 'BE'},
                {country: 'Bolivia', code: 'BO'},
                {country: 'Brazil', code: 'BR'},
                {country: 'Bulgaria', code: 'BG'},
                {country: 'Canada', code: 'CA'},
                {country: 'Chile', code: 'CL'},
                {country: 'Colombia', code: 'CO'},
                {country: 'Costa Rica', code: 'CR'},
                {country: 'Croatia', code: 'HR'},
                {country: 'Cyprus', code: 'CY'},
                {country: 'Czech Republic', code: 'CZ'},
                {country: 'Denmark', code: 'DK'},
                {country: 'Dominican Republic', code: 'DO'},
                {country: 'Egypt', code: 'EG'},
                {country: 'Estonia', code: 'EE'},
                {country: 'Finland', code: 'FI'},
                {country: 'France', code: 'FR'},
                {country: 'Germany', code: 'DE'},
                {country: 'Greece', code: 'GR'},
                {country: 'Hong Kong SAR China', code: 'HK'},
                {country: 'Hungary', code: 'HU'},
                {country: 'Iceland', code: 'IS'},
                {country: 'India', code: 'IN'},
                {country: 'Indonesia', code: 'ID'},
                {country: 'Ireland', code: 'IE'},
                {country: 'Israel', code: 'IL'},
                {country: 'Italy', code: 'IT'},
                {country: 'Japan', code: 'JP'},
                {country: 'Latvia', code: 'LV'},
                {country: 'Liechtenstein', code: 'LI'},
                {country: 'Lithuania', code: 'LT'},
                {country: 'Luxembourg', code: 'LU'},
                {country: 'Malta', code: 'MT'},
                {country: 'Mexico ', code: 'MX'},
                {country: 'Netherlands', code: 'NL'},
                {country: 'New Zealand', code: 'NZ'},
                {country: 'Norway', code: 'NO'},
                {country: 'Paraguay', code: 'PY'},
                {country: 'Peru', code: 'PE'},
                {country: 'Poland', code: 'PL'},
                {country: 'Portugal', code: 'PT'},
                {country: 'Romania', code: 'RO'},
                {country: 'Singapore', code: 'SG'},
                {country: 'Slovakia', code: 'SK'},
                {country: 'Slovenia', code: 'SI'},
                {country: 'Spain', code: 'ES'},
                {country: 'Sweden', code: 'SE'},
                {country: 'Switzerland', code: 'CH'},
                {country: 'Thailand', code: 'TH'},
                {country: 'Trinidad & Tobago', code: 'TT'},
                {country: 'United Arab Emirates', code: 'AE'},
                {country: 'United Kingdom', code: 'GB'},
                {country: 'United States', code: 'US'},
                {country: 'Uruguay', code: 'UY'}
            ],
            success: false,
        }
    }
}
</script>
