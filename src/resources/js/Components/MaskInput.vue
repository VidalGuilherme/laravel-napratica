<script setup>
import { onMounted, ref } from 'vue';
import { vMaska } from "maska";

defineProps({
    modelValue: String,
    mask: String,
    tokens: String,
    replace: false,
    eager: false,
    reversed: false,
    isDisabled: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        v-maska 
        :data-maska="mask" 
        :data-maska-tokens="tokens"
        :data-maska-tokens-replace="replace"
        :data-maska-eager="eager"
        :data-maska-reversed="reversed"
        ref="input"
        type="text"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :class="isDisabled ? 'disabled:opacity-75 dark:bg-gray-500 bg-gray-200' : ''"
        :value="modelValue"
        :disabled="isDisabled"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
