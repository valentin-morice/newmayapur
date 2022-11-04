import {reactive} from 'vue'

export default function useForm() {
    const values = reactive({
        firstname: '',
        lastname: '',
        email: '',
        city: '',
        country: '',
        address: '',
        state: '',
        postalcode: '',
        customerId: '',
        clientSecret: '',
        price: '',
        amount: '',
        currency: '',
        paymentMethod: '',
        showbuttons: true,
        csrf: '',
    })

    return {values}
}
