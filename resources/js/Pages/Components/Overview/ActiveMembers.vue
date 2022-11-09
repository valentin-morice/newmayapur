<template>
    <div class="rounded-2xl px-6 pt-3 pb-5 shadow-lg bg-white">
        <h2 class="font-bold text-xl text-gray-700">Active Members</h2>
        <progress class="mt-6 progress progress-primary" :value="percentage.value" max="100"></progress>
        <div class="flex justify-between mt-4">
            <p><span class="uppercase font-bold text-gray-700">ACTIVE: </span>{{ percentage.value }}%</p>
            <p><span class="uppercase font-bold text-gray-700">CANCELLED: </span>{{ 100 - percentage.value }}%
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['percentage']
}
</script>
