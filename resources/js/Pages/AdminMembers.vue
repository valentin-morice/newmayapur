<template>
    <Admin>
        <h1 class="font-bold text-3xl text-gray-700 pt-3 px-6">All Members</h1>
        <div class="calculate rounded-2xl m-4 p-6 pb-5 shadow-lg bg-white">
            <input v-model="search" type="text" placeholder="Search For Members..."
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
                    <tr v-for="member in members.data">
                        <th>{{ member.id }}</th>
                        <td>
                            <Link :href="'/admin/members/' + member.id">{{ member.name }}</Link>
                        </td>
                        <td>{{ member.date }}</td>
                        <td><p><b>{{ getCurrency(member.currency) }}</b> {{ member.amount }}.00</p></td>
                        <td>{{ member.status }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <Component
                :is="link.url ? 'Link' : 'span'"
                v-for="link in members.links"
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
    props: ['members'],
    methods: {
        getCurrency(code) {
            return getSymbolFromCurrency(code);
        }
    },
    data() {
        return {
            search: '',
        }
    },
    watch: {
        search:
            debounce(function (value) {
                Inertia.get('/admin/members', {search: value}, {preserveState: true, replace: true})
            }, 500)

    }
}
</script>
