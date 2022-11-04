<template>
    <div class="cursor-pointer square-box p-4 border-4 rounded-xl">
        <span class="font-bold text-xl square-content">{{ amount }}</span>
        <span v-if="currency && selectedAmount === amount"
              class="p-1 px-2 rounded bg-blue-500 absolute text-[10px] text-white font-bold bottom-1 right-1">{{
                currency
            }}</span>
    </div>
</template>

<script>
export default {
    props: ['amount', 'currency', 'selectedAmount'],
}
</script>

<style scoped>
.square-box {
    position: relative;
    width: 50%;
    overflow: hidden;
}

.square-box:before {
    content: "";
    display: block;
    padding-top: 100%;
}

.square-content {
    position: absolute;
    top: 50%;
    left: 0;
    bottom: 0;
    right: 0;
    text-align: center;
    transform: translateY(-45%);
}
</style>


