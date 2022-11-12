<template>
    <input
        ref="inputRef"
        type="text"
    />
</template>

<script>
import {useCurrencyInput} from 'vue-currency-input'
import {watch} from "vue";

export default {
    name: 'CurrencyInput',
    props: {
        modelValue: Number,
        options: Object
    },
    setup(props) {
        const {inputRef, setOptions} = useCurrencyInput(props.options)
        watch(
            () => props.options,
            (options) => {
                setOptions(options)
            }
        )
        return {inputRef}
    }
}
</script>
