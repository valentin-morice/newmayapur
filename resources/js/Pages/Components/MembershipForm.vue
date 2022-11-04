<template>
    <div class="rounded-xl bg-white p-8 shadow-lg mx-auto" style="width: 620px">
        <SlideUpDown v-model="active" :duration="1000">
            <Component
                :form="form"
                :error="error[int]"
                class="pt-2"
                :is="steps[int]"></Component>
        </SlideUpDown>
        <div v-if="form.values.showbuttons !== false" class="flex justify-between gap-2">
            <button @click="previous" :class="int === 0 ? 'btn-disabled' : ''"
                    class="btn btn-primary w-44 mt-6">
                &#171; Previous
            </button>
            <button @click="next" class="btn w-44 btn-primary mt-6">Next &#187;</button>
        </div>
    </div>
</template>

<script>
import FirstStep from "./MembershipFormSteps/FirstStep";
import SecondStep from "./MembershipFormSteps/SecondStep";
import ThirdStep from "./MembershipFormSteps/ThirdStep";
import FourthStep from "./MembershipFormSteps/FourthStep";
import FifthStep from "./MembershipFormSteps/FifthStep";
import useForm from "../Composables/formValues";

export default {
    data() {
        return {
            steps: [
                'FirstStep',
                'SecondStep',
                'ThirdStep',
                'FourthStep',
                'FifthStep'
            ],
            int: 0,
            active: true,
            form: useForm(),
            error: [
                {
                    firstname: '',
                    lastname: '',
                    email: '',
                },
                {
                    currency: '',
                    amount: '',
                    paymentMethod: '',
                },
                {
                    address: '',
                    city: '',
                    country: '',
                    postalcode: '',
                },
                {
                    priceId: '',
                }
            ]
        }
    },
    components: {
        FirstStep,
        SecondStep,
        ThirdStep,
        FourthStep,
        FifthStep,
    },
    methods: {
        next() {
            if (this.int === 0) {
                if (Object.keys(this.error[0]).length !== 0) return
            } else if (this.int === 1) {
                if (Object.keys(this.error[1]).length !== 0) return
            } else if (this.int === 2) {
                if (Object.keys(this.error[2]).length !== 0) return
            }
            this.active = false
            setTimeout(() => {
                this.int++
            }, 1000)
            setTimeout(() => {
                this.active = true
            }, 1050)
        },
        previous() {
            this.active = false
            setTimeout(() => {
                this.int--
            }, 1000)
            setTimeout(() => {
                this.active = true
            }, 1050)
        },
    },
    mounted() {
        this.form.values.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
}
</script>
