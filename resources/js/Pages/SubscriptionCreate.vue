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
                <div v-if="form === 'member'">
                    <span
                        class="uppercase font-bold text-white shadow-md bg-secondary rounded-[6px] px-3 py-1.5 ml-0.5">Donate Monthly</span>
                    <h1 class="text-5xl pt-5 font-bold">Become a Member</h1>
                </div>
                <h1 v-else class="text-5xl font-bold">Make a Single Donation</h1>
                <p v-if="form === 'member'" class="py-6">
                    Members are the core support of ISKCON New Mayapur. By becoming
                    a member, you are contributing to the steady growth of New Mayapur's activities and community.
                </p>
                <p v-else class="py-6">
                    Make a one-off donation now. Single donations are a great way for you to help, in your own terms and
                    at your own pace.
                </p>
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
