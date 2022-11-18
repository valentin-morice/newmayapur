<template>
    <div class="hero relative min-h-screen bg-base-200">
        <div class="absolute top-6 mx-auto md:mx-0 md:right-10 flex gap-2">
            <span @click="() => this.form = 'member'"
                  class="text-white text-sm md:text-base px-4 py-2 font-bold rounded-[8px] bg-primary hover:cursor-pointer z-20">Become a Member</span>
            <span @click="() => this.form = 'donation'"
                  class="text-white text-sm md:text-base px-4 py-2 font-bold rounded-[8px] bg-primary hover:cursor-pointer z-20">Single Donation</span>
        </div>
        <div class="lg:px-16 px-2 hero-content flex-col lg:flex-row-reverse">
            <div class="text-center lg:text-left lg:ml-8">
                <h1 v-if="form === 'member'" class="text-5xl font-bold">Become a Member</h1>
                <h1 v-else class="text-5xl font-bold">Make a Single Donation</h1>
                <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                    exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
            </div>
            <MembershipForm :csrf="csrf" v-if="form === 'member'"/>
            <DonationForm :csrf="csrf" v-else-if="form === 'donation'"/>
        </div>
    </div>
</template>

<script>
import Base from "./Layout/Base";
import MembershipForm from "./Components/MembershipForm";
import DonationForm from "./Components/DonationForm";

export default {
    layout: Base,
    components: {
        MembershipForm,
        DonationForm
    },
    methods: {},
    data() {
        return {
            form: 'member',
        }
    },
    props: ['csrf']

}
</script>
