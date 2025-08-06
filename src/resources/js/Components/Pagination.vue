<script setup>
const props = defineProps({ links: { type: Array, required: true } })
const emit = defineEmits(['jump'])
</script>

<template>
    <nav class="flex flex-wrap gap-2">
        <template v-for="(link, i) in links" :key="i">
            <button
                v-if="link.url"
                class="px-3 py-1 rounded border text-sm"
                :class="{
          'bg-blue-600 text-white border-blue-600': link.active,
          'bg-white hover:bg-gray-50 border-gray-300': !link.active
        }"
                @click="emit('jump', link.url)"
                v-html="link.label"
            />
            <span
                v-else
                class="px-3 py-1 rounded border border-gray-200 text-gray-400 text-sm"
                v-html="link.label"
            />
        </template>
    </nav>
</template>
