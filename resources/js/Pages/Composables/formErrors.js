import {reactive} from 'vue'

export default function useFormErrors() {
    const values = reactive({
        server: false,
        first: {
            firstname: '',
            lastname: '',
            email: '',
        },
        second: {
            amount: '',
            payment_method: '',
            currency: 0,
        },
        third: {
            address: '',
            city: '',
            country: '',
            postal_code: '',
        },
    })

    return {values}
}
