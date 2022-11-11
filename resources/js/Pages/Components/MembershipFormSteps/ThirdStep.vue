<template>
    <div>
        <ErrorNotification :error="errors.values.server"/>
        <div v-if="form.values.member.subscription.payment_method === 'gocardless'">
            <h2 class="text-2xl font-bold text-gray-700 mb-3">Fill in your details</h2>
            <p class="pb-6">Please click on the button to enter your address and credentials.</p>
            <a :href="link">
                <button :class="link.includes('gocardless') ? '' : 'btn-disabled'" class="btn btn-primary w-full">Pay
                    Now
                </button>
            </a>
        </div>
        <form v-else class="mb-1">
            <input type="text" :class="errors.values.third.city ? 'bg-red-200 placeholder-red-600' : ''"
                   v-model="form.values.member.address.city"
                   :placeholder="errors.values.third.city ? errors.values.third.city : 'City'"
                   class="input input-bordered w-full"/>
            <select class="mt-4 select select-bordered w-full"
                    v-model="form.values.member.address.country">
                <option value="" class="font-normal text-gray-300" disabled selected>Country</option>
                <option v-for="item in countries" :value="item.code">
                    {{ item.country }}
                </option>
            </select>
            <input :class="errors.values.third.address ? 'bg-red-200 placeholder-red-600' : ''" type="text"
                   v-model="form.values.member.address.street"
                   :placeholder="errors.values.third.address ? errors.values.third.address : 'Address'"
                   class="mt-4 input input-bordered w-full"/>
            <div class="flex space-x-2">
                <input type="text" v-model="form.values.member.address.state" placeholder="State"
                       class="mt-4 input input-bordered w-1/2"/>
                <input type="text" :class="errors.values.third.postal_code ? 'bg-red-200 placeholder-red-600' : ''"
                       v-model="form.values.member.address.postal_code"
                       :placeholder="errors.values.third.postal_code ? errors.values.third.postal_code : 'Postal Code'"
                       class="mt-4 input input-bordered w-1/2"/>
            </div>
        </form>
    </div>
</template>

<script>
import ErrorNotification from "../UI/ErrorNotification";
import notEmpty from "../../Composables/validateInput"

export default {
    components: {ErrorNotification},
    props: ['form', "errors"],
    beforeMount() {
        if (this.form.values.member.subscription.payment_method === 'gocardless') {
            this.form.values.utils.show_buttons = false
            const vm = this
            fetch('/gocardless/create', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.form.values.utils.csrf,
                },
                body: JSON.stringify(this.form.values)
            })
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error();
                })
                .then((data) => {
                    vm.link = data.link
                })
                .catch(function () {
                    vm.errors.values.server = true;
                });
        } else if (this.form.values.member.subscription.payment_method === 'stripe') {
            const vm = this
            fetch('/stripe/create-customer',
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': vm.form.values.utils.csrf
                    },
                    body: JSON.stringify(vm.form.values)
                }
            )
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error();
                })
                .then((data) => {
                        vm.form.values.member.subscription.customer_id = data.customer_id
                    }
                )
                .catch(function () {
                    vm.errors.values.server = true;
                });
        }
    },
    data() {
        return {
            name: '',
            link: '',
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
            ]
        }
    },
    watch: {
        'form.values.member.address.street'(value) {
            if (value.length < 2) {
                this.errors.values.third.address = 'Please enter a valid address.'
            } else {
                delete this.errors.values.third.address
            }
        },
        'form.values.member.address.city'(value) {
            if (value.length < 2) {
                this.errors.values.third.city = 'Please enter a valid city.'
            } else {
                delete this.errors.values.third.city
            }
        },
        'form.values.member.address.postal_code'(value) {
            if (value.length < 2) {
                this.errors.values.third.postal_code = 'Invalid code.'
            } else {
                delete this.errors.values.third.postal_code
            }
        },
        'form.values.member.address.country'(value) {
            if (value.length === 0) {
                this.errors.values.third.country = 1
            } else {
                delete this.errors.values.third.country
            }
        }
    },
}
</script>
