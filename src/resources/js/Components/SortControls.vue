<script setup>
const props = defineProps({
    sorts: { type: Array, required: true }, // [{value,label}]
    dirs:  { type: Array, required: true }, // [{value,label}]
    sort:  { type: String, default: 'id' },
    dir:   { type: String, default: 'desc' },
})
const emit = defineEmits(['update:sort', 'update:dir'])
</script>

<template>
    <div class="flex items-center gap-2">
        <select
            class="rounded border-gray-300 text-sm px-2 py-2"
            :value="sort"
            @change="emit('update:sort', $event.target.value)"
        >
            <option v-for="s in sorts" :key="s.value" :value="s.value">{{ s.label }}</option>
        </select>
        <select
            class="rounded border-gray-300 text-sm px-2 py-2"
            :value="dir"
            @change="emit('update:dir', $event.target.value)"
        >
            <option v-for="d in dirs" :key="d.value" :value="d.value">{{ d.label }}</option>
        </select>
    </div>
</template>
