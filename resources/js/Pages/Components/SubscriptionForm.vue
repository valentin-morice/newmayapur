<template>
    <div class="hero min-h-screen bg-base-200">
        <div class="px-16 hero-content flex-col lg:flex-row-reverse">
            <div class="text-center lg:text-left lg:ml-8">
                <h1 class="text-5xl font-bold">Devenez Membre</h1>
                <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                    exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
            </div>
            <div class="rounded-xl bg-white p-8 shadow-lg mx-auto" style="width: 620px">
                <SlideUpDown v-model="active" :duration="1000">
                    <Component :form="form"
                               :error="error[int]"
                               class="pt-2"
                               :is="steps[int]"></Component>
                </SlideUpDown>
                <div v-if="int !== 4" class="flex justify-between gap-2">
                    <button @click="previous" :class="int === 0 ? 'btn-disabled' : ''"
                            class="btn btn-primary w-44 mt-6">
                        &#171; Previous
                    </button>
                    <button @click="next" class="btn w-44 btn-primary mt-6">Next &#187;</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FirstStep from "./SubscriptionFormSteps/FirstStep";
import SecondStep from "./SubscriptionFormSteps/SecondStep";
import ThirdStep from "./SubscriptionFormSteps/ThirdStep";
import FourthStep from "./SubscriptionFormSteps/FourthStep";
import FifthStep from "./SubscriptionFormSteps/FifthStep";
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
            error: [{
                firstname: '',
                lastname: '',
                email: ''
            },
                {
                    address: '',
                    city: '',
                    country: '',
                    postalcode: '',
                },
                {
                    priceId: '',
                }]
        }
    },
    components: {
        FirstStep,
        SecondStep,
        ThirdStep,
        FourthStep,
        FifthStep
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
    }
}
</script>
