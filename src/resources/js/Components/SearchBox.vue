<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: { type: String, default: 'Search...' },
})
const emit = defineEmits(['update:modelValue', 'search'])

const q = ref(props.modelValue)
watch(() => props.modelValue, v => { if (v !== q.value) q.value = v })

let timer = null
watch(q, (v) => {
    emit('update:modelValue', v)
    clearTimeout(timer)
    timer = setTimeout(() => emit('search'), 400) // 400msデバウンス
})
</script>

<template>
    <div class="flex items-center gap-2">
        <input
            :value="q"
            @input="q = $event.target.value"
            :placeholder="placeholder"
            class="w-full md:w-80 rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            type="search"
        />
    </div>
</template>
