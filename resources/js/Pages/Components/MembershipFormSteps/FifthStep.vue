<template>
    <form id="payment-form" class="w-100" @submit.prevent="onSubmit">
        <div id="payment-element">
            <!-- Elements will create form elements here -->
        </div>
        <button @click="() => {this.clicked = true}" v-html="clicked ? 'Loading...' : 'Subscribe'"
                class="btn btn-primary w-full mt-4"
                id="submit">
        </button>
        <div class="mt-3 alert alert-error shadow-lg" v-if="error">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="error-message"></span>
            </div>
        </div>
    </form>
</template>

<script>

export default {
    props: ['form'],
    data() {
        return {
            stripe: Stripe(
                'pk_live_51Hhyh0BaqalmgsW81p7opcUyBlqX3TVwAB15enVc7r9O3QbYhTSvsqV3lRfZbAGNh1J5IXKnPz24PtzYC802hJ7r00ANQtMzTi'
            ),
            error: false,
            clicked: false,
        }
    },
    beforeMount() {
        this.form.values.utils.show_buttons = false
    },
    computed: {
        elements() {
            return this.stripe.elements({
                clientSecret: this.form.values.member.subscription.client_secret,
                appearance: {}
            })
        },
        email() {
            return this.form.values.member.email
        }
    },
    mounted() {
        // Create and mount the Payment Element
        const paymentElement = this.elements.create('payment');
        paymentElement.mount('#payment-element');
    },
    methods: {
        async onSubmit() {
            const elements = this.elements;
            const email = this.email;
            const {error} = await this.stripe.confirmPayment({
                //`Elements` instance that was used to create the Payment Element
                elements,
                confirmParams: {
                    return_url: window.location.protocol +
                        "//" +
                        window.location.host +
                        "/" +
                        "stripe/success",
                    receipt_email: email
                }
            });

            if (error) {
                // This point will only be reached if there is an immediate error when
                // confirming the payment. Show error to your customer (for example, payment
                // details incomplete)
                this.error = true
                const messageContainer = document.querySelector('#error-message');
                messageContainer.textContent = error.message;
            } else {
                // Your customer will be redirected to your `return_url`. For some payment
                // methods like iDEAL, your customer will be redirected to an intermediate
                // site first to authorize the payment, then redirected to the `return_url`.
            }
        },
    }
}
</script>

<style scoped>
form {
    width: 100%;
    min-width: 365px;
    align-self: center;
}

@media only screen and (max-width: 600px) {
    form {
        min-width: initial;
    }
}
</style>
