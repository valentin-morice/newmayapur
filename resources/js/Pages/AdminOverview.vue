<template>
    <Admin>
        <h1 class="font-bold text-3xl text-gray-700 pt-3 px-6">Membership Overview</h1>
        <div class="w-full grid grid-cols-2 m-6 gap-4">
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
                            <CountryFlag country='fr' rounded="true" size='normal'/>
                            <p>76</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='nz' rounded="true" size='normal'/>
                            <p>19</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='gb' rounded="true" size='normal'/>
                            <p>33</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='au' rounded="true" size='normal'/>
                            <p>24</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='us' rounded="true" size='normal'/>
                            <p>8</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='in' rounded="true" size='normal'/>
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
                            <CountryFlag country='fr' rounded="true" size='normal'/>
                            <p><b>€ </b>3,450.00</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='nz' rounded="true" size='normal'/>
                            <p><b>$ </b>1,243.64</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='gb' rounded="true" size='normal'/>
                            <p><b>£ </b>3,353.42</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='au' rounded="true" size='normal'/>
                            <p><b>$ </b>1,867.85</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='us' rounded="true" size='normal'/>
                            <p><b>$ </b>633.12</p>
                        </div>
                        <div class="rounded-xl px-5 py-2 flex items-center bg-gray-100 justify-between">
                            <CountryFlag country='in' rounded="true" size='normal'/>
                            <p><b>₹ </b>81,234.30</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <!-- New Members Module -->
                <div class="rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
                    <h2 class="font-bold text-xl text-gray-700">New Members</h2>
                    <div class="mt-4 overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <!-- head -->
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- row 1 -->
                            <tr>
                                <td>Cy Ganderton</td>
                                <td>31/10/22</td>
                                <td><p><b>$ </b>32.00</p></td>
                            </tr>
                            <!-- row 2 -->
                            <tr>
                                <td>Hart Hagerty</td>
                                <td>02/11/22</td>
                                <td><b>€ </b>16.00</td>
                            </tr>
                            <!-- row 3 -->
                            <tr>
                                <td>Brice Swyre</td>
                                <td>05/11/22</td>
                                <td><b>€ </b>45.00</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Cancellations Module -->
                <div class="mt-4 rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
                    <h2 class="font-bold text-xl text-gray-700">Cancellations</h2>
                    <div class="mt-4 overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <!-- head -->
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- row 1 -->
                            <tr>
                                <td>Cy Ganderton</td>
                                <td>31/10/22</td>
                                <td><p><b>$ </b>32.00</p></td>
                            </tr>
                            <!-- row 2 -->
                            <tr>
                                <td>Hart Hagerty</td>
                                <td>02/11/22</td>
                                <td><b>€ </b>16.00</td>
                            </tr>
                            <!-- row 3 -->
                            <tr>
                                <td>Brice Swyre</td>
                                <td>05/11/22</td>
                                <td><b>€ </b>45.00</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
                <h2 class="font-bold text-xl text-gray-700">Active Members</h2>
                <progress class="mt-6 progress progress-primary" value="86" max="100"></progress>
                <div class="flex justify-between mt-4">
                    <p><span class="uppercase font-bold text-gray-700">ACTIVE: </span>86%</p>
                    <p><span class="uppercase font-bold text-gray-700">CANCELLED: </span>14%</p>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from "./Layout/Admin";
import CountryFlag from "vue-country-flag-next";

export default {
    components: {
        Admin,
        CountryFlag
    }
}
</script>

<style>
.normal-flag {
    margin: 0 0 0 -12px !important;
}
</style>
