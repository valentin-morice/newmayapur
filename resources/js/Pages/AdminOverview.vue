<template>
    <Admin>
        <h1 class="font-bold text-3xl text-gray-700 pt-3 px-6">Membership Overview</h1>
        <div class="calculate grid grid-cols-2 m-4 gap-4">
            <div>
                <!-- Members Module -->
                <div class="rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
                    <h2 class="font-bold text-xl text-gray-700">Members</h2>
                    <div class="p-2 my-4 flex bg-gray-100 rounded justify-between">
                        <span class="uppercase font-bold">Total</span>
                        <span>201</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='fr' :rounded="true" size='normal'/>
                            <p>76</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='nz' :rounded="true" size='normal'/>
                            <p>19</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='gb' :rounded="true" size='normal'/>
                            <p>33</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='au' :rounded="true" size='normal'/>
                            <p>24</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='us' :rounded="true" size='normal'/>
                            <p>8</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='in' :rounded="true" size='normal'/>
                            <p>12</p>
                        </div>
                    </div>
                </div>
                <!-- Subscriptions Module -->
                <div class="mt-4 rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
                    <h2 class="font-bold text-xl text-gray-700">Subscriptions</h2>
                    <div class="p-2 my-4 flex bg-gray-100 rounded justify-between">
                        <p><span class="uppercase font-bold">Total</span> /month</p>
                        <span><b>€ </b>8,198.00</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='fr' :rounded="true" size='normal'/>
                            <p><b>€ </b>3,450.00</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='nz' :rounded="true" size='normal'/>
                            <p><b>$ </b>1,243.64</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='gb' :rounded="true" size='normal'/>
                            <p><b>£ </b>3,353.42</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='au' :rounded="true" size='normal'/>
                            <p><b>$ </b>1,867.85</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='us' :rounded="true" size='normal'/>
                            <p><b>$ </b>633.12</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='in' :rounded="true" size='normal'/>
                            <p><b>₹ </b>81,234.30</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <!-- New Members Module -->
                <NewMovements :members="new_members" title="New Members"/>
                <!-- Cancellations Module -->
                <NewMovements class="mt-4" :members="new_cancels" title="Cancellations"/>
            </div>
            <!-- Active Members Module -->
            <ActiveMembers :percentage="percentage"/>
        </div>
    </Admin>
</template>

<script>
import Admin from "./Layout/Admin";
import CountryFlag from "vue-country-flag-next";
import NewMovements from "./Components/Overview/NewMovements";
import ActiveMembers from "./Components/Overview/ActiveMembers";

export default {
    components: {
        ActiveMembers,
        NewMovements,
        Admin,
        CountryFlag
    },
    props: ['new_members', 'new_cancels', 'percentage']
}
</script>

<style scoped>
.normal-flag {
    margin: 0 0 0 -12px !important;
}
</style>
