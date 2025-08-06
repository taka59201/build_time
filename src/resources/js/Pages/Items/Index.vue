<script setup>
import { reactive, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import SearchBox from '@/Components/SearchBox.vue'
import SortControls from '@/Components/SortControls.vue'
import PageSize from '@/Components/PageSize.vue'
import FiltersPanel from '@/Components/FiltersPanel.vue'

// props
const props = defineProps({
    items: { type: Object, required: true },
    filters: { type: Object, required: true },
    options: { type: Object, required: true },
})

// クエリ状態（双方向）
const state = reactive({
    q: props.filters.q ?? '',
    sort: props.filters.sort ?? 'id',
    dir: props.filters.dir ?? 'desc',
    per_page: props.filters.per_page ?? 20,
    price_min: props.filters.price_min ?? '',
    price_max: props.filters.price_max ?? '',
})

// クエリ反映（デバウンスはSearchBox側）
const submit = (page = 1) => {
    const data = { ...state, page }
    router.get('/items', data, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}

const goPage = (url) => {
    if (!url) return
    router.visit(url, { preserveState: true, preserveScroll: true, replace: true })
}

// select変更などで即反映したいフィールド
watch(() => [state.sort, state.dir, state.per_page], () => submit(1))
</script>

<template>
    <AppLayout>
        <div class="flex flex-col gap-4 mb-4 md:flex-row md:items-end md:justify-between">
            <div class="flex-1 flex flex-col gap-3 md:flex-row md:items-end">
                <SearchBox v-model="state.q" @search="submit(1)" class="md:w-80" />
                <FiltersPanel
                    v-model:priceMin="state.price_min"
                    v-model:priceMax="state.price_max"
                    @apply="submit(1)"
                />
            </div>
            <div class="flex items-center gap-3">
                <SortControls
                    v-model:sort="state.sort"
                    v-model:dir="state.dir"
                    :sorts="options.sorts"
                    :dirs="options.dirs"
                />
                <PageSize v-model="state.per_page" :options="options.perPages" />
            </div>
        </div>

        <div class="bg-white rounded shadow divide-y">
            <div
                v-for="item in items.data"
                :key="item.id"
                class="px-4 py-3 flex items-center justify-between"
            >
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded bg-gray-100 text-gray-600 text-sm">{{ item.id }}</span>
                    <div class="font-medium">{{ item.name }}</div>
                </div>
                <div class="text-gray-700 font-semibold">¥{{ item.price }}</div>
            </div>
        </div>

        <div class="mt-6">
            <Pagination :links="items.links" @jump="goPage" />
        </div>
    </AppLayout>
</template>
