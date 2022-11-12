<template>
    <div class="rounded-xl bg-white p-8 shadow-lg mx-auto" style="width: 620px">
        <FirstStep/>
        <div class="flex justify-between gap-2">
            <button
                class="btn btn-primary w-44 mt-6 btn-disabled">
                &#171; Previous
            </button>
            <button
                class="btn w-44 btn-primary mt-6">
                Next &#187;
            </button>
        </div>
    </div>
</template>

<script>
import FirstStep from "./DonationFormSteps/FirstStep";

export default {
    components: {FirstStep}
}
</script>
