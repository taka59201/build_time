<script setup>
import { ref } from 'vue'
const props = defineProps({
    modelValue: { type: Array, default: () => [] },
    placeholder: { type: String, default: 'Add a tag and press Enter' },
})
const emit = defineEmits(['update:modelValue'])
const input = ref('')

function addTag() {
    const v = input.value.trim()
    if (!v) return
    if (!props.modelValue.includes(v)) {
        emit('update:modelValue', [...props.modelValue, v])
    }
    input.value = ''
}
function removeTag(t) {
    emit('update:modelValue', props.modelValue.filter(x => x !== t))
}
</script>

<template>
    <div class="border rounded p-2">
        <div class="flex flex-wrap gap-2 mb-2">
      <span
          v-for="t in modelValue" :key="t"
          class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 text-blue-700 text-xs"
      >
        {{ t }}
        <button type="button" class="text-blue-700" @click="removeTag(t)">×</button>
      </span>
        </div>
        <input
            v-model="input"
            :placeholder="placeholder"
            class="w-full border rounded px-2 py-1 text-sm"
            @keydown.enter.prevent="addTag"
        />
    </div>
</template>
