<template>
    <div class="rounded-xl bg-white p-8 shadow-lg mx-auto max-w-md md:w-[700px]">
        <SlideUpDown v-model="active" :duration="1000">
            <Component
                :form="form"
                :errors="errors"
                class="pt-2"
                :is="steps[int]"
            ></Component>
        </SlideUpDown>
        <div v-if="form.values.utils.show_buttons !== false" class="grid grid-cols-2 gap-2">
            <button @click="previous" :class="int === 0 ? 'btn-disabled' : ''"
                    class="btn btn-primary w-100 mt-6">
                &#171; Previous
            </button>
            <button @click="next" :class="errors.values.server ? 'btn-disabled' : ''"
                    class="btn w-100 btn-primary mt-6">
                Next &#187;
            </button>
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
import useFormErrors from "../Composables/formErrors";

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
            errors: useFormErrors(),
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
                if (Object.keys(this.errors.values.first).length !== 0) return
            } else if (this.int === 1) {
                if (Object.keys(this.errors.values.second).length !== 0) return
            } else if (this.int === 2) {
                if (Object.keys(this.errors.values.third).length !== 0) return
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
        this.form.values.utils.csrf = this.csrf
    },
    props: ['csrf']
}
</script>
