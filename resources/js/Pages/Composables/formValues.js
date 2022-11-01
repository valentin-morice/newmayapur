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
        priceId: '',
        clientSecret: '',
        price: ''
    })

    return {values}
}
