<template>
    <Admin>
        <h1 class="font-bold text-3xl text-gray-700 pt-3 px-6">All Payments</h1>
        <div class="calculate rounded-2xl m-4 p-6 pb-5 shadow-lg bg-white">
            <input v-model="search" type="text" placeholder="Search For Payments..."
                   class="mb-6 input input-bordered w-full max-w-xs"/>
            <div class="overflow-x-auto mb-8">
                <table class="table table-fixed table-zebra w-full">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="payment in payments.data">
                        <th>{{ payment.id }}</th>
                        <td>
                            <p>{{ payment.name }}</p>
                        </td>
                        <td>{{ payment.date }}</td>
                        <td><p><b>{{ getCurrency(payment.currency) }}</b>
                            {{ (Math.round(payment.amount * 100) / 100).toFixed(2) }}</p></td>
                        <td>{{ payment.status }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <Component
                :is="link.url ? 'Link' : 'span'"
                v-for="link in payments.links"
                :href="link.url"
                v-html="link.label"
                class="py-2 px-4 rounded bg-base-200 m-1"
                :class="link.url ? '' : 'text-gray-500', link.active ? 'font-bold bg-primary text-white' : ''"
            />
        </div>
    </Admin>
</template>

<script>
import Admin from "./Layout/Admin";
import getSymbolFromCurrency from 'currency-symbol-map'
import {Link} from "@inertiajs/inertia-vue3";
import {debounce} from "lodash";
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {
        Admin,
        Link
    },
    props: ['payments', 'query'],
    methods: {
        getCurrency(code) {
            return getSymbolFromCurrency(code);
        }
    },
    data() {
        return {
            search: this.query,
        }
    },
    watch: {
        search:
            debounce(function (value) {
                Inertia.get('/admin/payments', {search: value}, {preserveState: true, replace: true})
            }, 500)

    }
}
</script>
