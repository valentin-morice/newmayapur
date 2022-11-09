<template>
    <div class="bg-base-200">
        <div class="h-screen flex justify-center items-center">
            <div class="w-1/3 text-center">
                <ion-icon
                    class="mx-auto block py-2 text-6xl mb-4 text-gray-700"
                    name="checkmark-circle-outline"
                ></ion-icon>
                <h1 class="font-bold text-3xl text-gray-700">Request Sent!</h1>
                <p class="mt-4">Your request has been sent and is currently being processed.<br>
                    It might take some time to reflect on your dashboard.</p>
                <Link href="/" class="btn btn-primary mt-12 w-1/2">Go Back</Link>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link
    }
}
</script>
