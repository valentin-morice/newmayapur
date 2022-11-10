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
            currency: '',
            amount: '',
            payment_method: '',
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
