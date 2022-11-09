<template>
    <div class="rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
        <h2 class="font-bold text-xl text-gray-700">{{ title }}</h2>
        <div class="mt-4 overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody v-for="member in members">
                <tr>
                    <td>
                        <Link :href="'/admin/members/' + member.member.id">
                            {{ member.member.name }}
                        </Link>
                    </td>
                    <td>{{ member.member.date }}</td>
                    <td>
                        <p>
                            <b>
                                {{ getCurrency(member.subscription.currency) }}
                            </b>
                            {{ member.subscription.amount }}.00
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import getSymbolFromCurrency from "currency-symbol-map";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    props: ['members', 'title'],
    components: {
        Link
    },
    methods: {
        getCurrency(code) {
            return getSymbolFromCurrency(code);
        }
    },
}
</script>
