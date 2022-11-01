<template>
    <SubscriptionForm></SubscriptionForm>
</template>

<script>
import SubscriptionForm from "../Components/SubscriptionForm";
import Base from "../Layout/Base";
import FirstStep from "../Components/SubscriptionFormSteps/FirstStep";

export default {
    layout: Base,
    components: {
        SubscriptionForm,
        FirstStep
    }
}
</script>
