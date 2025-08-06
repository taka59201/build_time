<script setup>
const props = defineProps({
    priceMin: { type: [String, Number], default: '' },
    priceMax: { type: [String, Number], default: '' },
})
const emit = defineEmits(['update:priceMin', 'update:priceMax', 'apply'])
</script>

<template>
    <div class="flex items-end gap-2">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Min Price</label>
            <input
                :value="priceMin"
                @input="emit('update:priceMin', $event.target.value)"
                type="number"
                class="w-28 rounded border border-gray-300 px-2 py-2 text-sm"
                min="0"
            />
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Max Price</label>
            <input
                :value="priceMax"
                @input="emit('update:priceMax', $event.target.value)"
                type="number"
                class="w-28 rounded border border-gray-300 px-2 py-2 text-sm"
                min="0"
            />
        </div>
        <button
            class="h-10 inline-flex items-center rounded bg-blue-600 px-3 text-white text-sm hover:bg-blue-700"
            @click="emit('apply')"
        >
            Apply
        </button>
    </div>
</template>
