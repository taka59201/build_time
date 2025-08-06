<script setup>
const props = defineProps({
    modelValue: { type: Boolean, default: false },
    label: { type: String, default: '' },
})
const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <label class="flex items-center gap-3 cursor-pointer select-none">
        <span class="text-sm text-gray-600">{{ label }}</span>
        <button
            type="button"
            @click="emit('update:modelValue', !modelValue)"
            :aria-pressed="modelValue"
            class="relative inline-flex h-6 w-11 items-center rounded-full transition bg-gray-300"
            :class="modelValue ? 'bg-blue-600' : 'bg-gray-300'"
        >
      <span
          class="inline-block h-5 w-5 transform rounded-full bg-white transition"
          :class="modelValue ? 'translate-x-5' : 'translate-x-1'"
      />
        </button>
    </label>
</template>
