import {reactive} from 'vue'

export default function useForm() {
    const values = reactive({
        member: {
            firstname: '',
            lastname: '',
            email: '',
            address: {
                city: '',
                country: '',
                street: '',
                state: '',
                postal_code: '',
            },
            subscription: {
                customer_id: '',
                client_secret: '',
                price: '',
                amount: null,
                currency: {currency: 'EUR', autoDecimalDigit: true, precision: 2},
                payment_method: '',
            }
        },
        utils: {
            show_buttons: true,
            csrf: '',
        },
    })

    return {values}
}
