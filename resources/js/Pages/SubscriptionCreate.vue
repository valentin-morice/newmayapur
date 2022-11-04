<template>
    <div class="hero min-h-screen bg-base-200">
        <div class="px-16 hero-content flex-col lg:flex-row-reverse">
            <div class="text-center lg:text-left lg:ml-8">
                <h1 class="text-5xl font-bold">Become a Member</h1>
                <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                    exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
            </div>
            <MembershipForm/>
        </div>
    </div>
</template>

<script>
import Base from "./Layout/Base";
import MembershipForm from "./Components/MembershipForm";

export default {
    layout: Base,
    components: {
        MembershipForm
    }
}
</script>
