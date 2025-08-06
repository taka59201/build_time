<script setup>
const props = defineProps({
    modelValue: { type: Number, default: 20 },
    options: { type: Array, default: () => [10,20,50,100] },
})
const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="flex items-center gap-2">
        <label class="text-sm text-gray-600">Per page</label>
        <select
            class="rounded border-gray-300 text-sm px-2 py-2"
            :value="modelValue"
            @change="emit('update:modelValue', +$event.target.value)"
        >
            <option v-for="n in options" :key="n" :value="n">{{ n }}</option>
        </select>
    </div>
</template>
