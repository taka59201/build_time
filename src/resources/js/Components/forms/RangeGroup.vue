<script setup>
const props = defineProps({
    min: { type: Number, default: 0 },
    max: { type: Number, default: 100 },
    step: { type: Number, default: 1 },
    modelValue: {
        type: Object,
        default: () => ({ from: 0, to: 100 }),
    },
    label: { type: String, default: 'Range' },
})
const emit = defineEmits(['update:modelValue'])
function update(key, v) {
    const next = { ...props.modelValue, [key]: +v }
    if (next.from > next.to) {
        if (key === 'from') next.to = next.from
        else next.from = next.to
    }
    next.from = Math.max(props.min, Math.min(next.from, props.max))
    next.to   = Math.max(props.min, Math.min(next.to,   props.max))
    emit('update:modelValue', next)
}
</script>

<template>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ label }}</label>
        <div class="flex items-center gap-2">
            <input
                type="number" class="w-24 border rounded px-2 py-1 text-sm"
                :min="min" :max="max" :step="step"
                :value="modelValue.from"
                @input="update('from', $event.target.value)"
            />
            <span class="text-gray-400">–</span>
            <input
                type="number" class="w-24 border rounded px-2 py-1 text-sm"
                :min="min" :max="max" :step="step"
                :value="modelValue.to"
                @input="update('to', $event.target.value)"
            />
        </div>
        <div class="mt-2 text-xs text-gray-500">
            {{ modelValue.from }} 〜 {{ modelValue.to }}
        </div>
    </div>
</template>
