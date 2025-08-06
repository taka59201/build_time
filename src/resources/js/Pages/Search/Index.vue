<script setup>
import { reactive, ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ToggleSwitch from '@/Components/forms/ToggleSwitch.vue'
import TagInput from '@/Components/forms/TagInput.vue'
import RangeGroup from '@/Components/forms/RangeGroup.vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
    keyword: '',
    description: '',
    categories: [],      // ['A','B','C']
    statuses: '',        // 'draft' | 'active' | 'archived'
    price: { from: 100, to: 5000 },
    rating: 3,
    dateFrom: '',
    dateTo: '',
    timeFrom: '',
    timeTo: '',
    createdFrom: '',
    createdTo: '',
    tags: [],
    includeOut: false,
    sort: 'relevance',
    perPage: 20,
    colors: [],
    size: [],
    attachment: null,
})

// ファイルはアップロードしない（フォームUI用）
function onFileChange(e) {
    const f = e.target.files?.[0]
    form.attachment = f ? { name: f.name, size: f.size } : null
}

const submitted = ref(false)
function submit(e) {
    e?.preventDefault?.()
    submitted.value = true
    // 結果ページは持たないため、ここではサーバーへ送らずプレビューのみ
    // もしサーバー側に記録したいなら:
    // router.post('/search/log', { ...form })
}
function resetAll() {
    Object.assign(form, {
        keyword: '',
        description: '',
        categories: [],
        statuses: '',
        price: { from: 100, to: 5000 },
        rating: 3,
        dateFrom: '',
        dateTo: '',
        timeFrom: '',
        timeTo: '',
        createdFrom: '',
        createdTo: '',
        tags: [],
        includeOut: false,
        sort: 'relevance',
        perPage: 20,
        colors: [],
        size: [],
        attachment: null,
    })
    submitted.value = false
}

const categoryOptions = ['A','B','C','D']
const colorOptions = ['Red','Blue','Green','Amber','Gray']
const sizeOptions = ['S','M','L','XL']
</script>

<template>
    <AppLayout>
        <form class="space-y-6" @submit="submit">
            <!-- 基本検索 -->
            <section class="bg-white rounded shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Basic</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Keyword -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keyword</label>
                        <input v-model="form.keyword" class="w-full border rounded px-3 py-2 text-sm" placeholder="e.g. laptop, phone" />
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort</label>
                        <select v-model="form.sort" class="w-full border rounded px-3 py-2 text-sm">
                            <option value="relevance">Relevance</option>
                            <option value="price_asc">Price (Low → High)</option>
                            <option value="price_desc">Price (High → Low)</option>
                            <option value="rating_desc">Rating</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea v-model="form.description" rows="3" class="w-full border rounded px-3 py-2 text-sm" placeholder="Free text..."></textarea>
                    </div>
                </div>
            </section>

            <!-- 詳細条件 -->
            <section class="bg-white rounded shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Filters</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Categories (checkbox group) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                        <div class="flex flex-wrap gap-3">
                            <label v-for="c in categoryOptions" :key="c" class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" :value="c" v-model="form.categories" />
                                <span>{{ c }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Status (radio) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="radio" value="draft" v-model="form.statuses" />
                                <span>Draft</span>
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="radio" value="active" v-model="form.statuses" />
                                <span>Active</span>
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="radio" value="archived" v-model="form.statuses" />
                                <span>Archived</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price range (custom component) -->
                    <RangeGroup v-model="form.price" :min="0" :max="10000" :step="50" label="Price Range (¥)" />

                    <!-- Rating (range) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating (0-5)</label>
                        <input type="range" min="0" max="5" step="0.5" v-model="form.rating" class="w-full" />
                        <div class="text-xs text-gray-500 mt-1">{{ form.rating }}</div>
                    </div>

                    <!-- Dates -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date range</label>
                        <div class="flex items-center gap-2">
                            <input type="date" v-model="form.dateFrom" class="border rounded px-2 py-1 text-sm">
                            <span class="text-gray-400">–</span>
                            <input type="date" v-model="form.dateTo" class="border rounded px-2 py-1 text-sm">
                        </div>
                    </div>

                    <!-- Times -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time range</label>
                        <div class="flex items-center gap-2">
                            <input type="time" v-model="form.timeFrom" class="border rounded px-2 py-1 text-sm">
                            <span class="text-gray-400">–</span>
                            <input type="time" v-model="form.timeTo" class="border rounded px-2 py-1 text-sm">
                        </div>
                    </div>

                    <!-- Datetime -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created From/To</label>
                        <div class="flex items-center gap-2">
                            <input type="datetime-local" v-model="form.createdFrom" class="border rounded px-2 py-1 text-sm">
                            <span class="text-gray-400">–</span>
                            <input type="datetime-local" v-model="form.createdTo" class="border rounded px-2 py-1 text-sm">
                        </div>
                    </div>

                    <!-- Colors (multi-select via checkboxes) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Colors</label>
                        <div class="flex flex-wrap gap-3">
                            <label v-for="c in colorOptions" :key="c" class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" :value="c" v-model="form.colors" />
                                <span>{{ c }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Size (checkbox group) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                        <div class="flex flex-wrap gap-3">
                            <label v-for="s in sizeOptions" :key="s" class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" :value="s" v-model="form.size" />
                                <span>{{ s }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Include out-of-stock (toggle) -->
                    <ToggleSwitch v-model="form.includeOut" label="Include out-of-stock" />

                    <!-- Tags (chips input) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                        <TagInput v-model="form.tags" />
                    </div>

                    <!-- Attachment (no upload) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Attachment (UI only)</label>
                        <input type="file" @change="onFileChange" class="w-full text-sm" />
                        <p v-if="form.attachment" class="text-xs text-gray-500 mt-1">
                            {{ form.attachment.name }} ({{ Math.round(form.attachment.size/1024) }} KB)
                        </p>
                    </div>

                    <!-- Per page -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Per page</label>
                        <select v-model.number="form.perPage" class="w-32 border rounded px-3 py-2 text-sm">
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- アクション -->
            <section class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-white text-sm hover:bg-blue-700">
                    Search
                </button>
                <button type="button" class="inline-flex items-center rounded border px-4 py-2 text-sm hover:bg-gray-50" @click="resetAll">
                    Reset
                </button>
                <span class="text-xs text-gray-500">※ 検索結果ページはありません。入力内容は下のプレビューに表示されます。</span>
            </section>

            <!-- プレビュー -->
            <section v-if="submitted" class="bg-white rounded shadow p-4">
                <h2 class="text-lg font-semibold mb-2">Your criteria (preview only)</h2>
                <pre class="text-xs bg-gray-50 border rounded p-3 overflow-auto">{{ form }}</pre>
            </section>
        </form>
    </AppLayout>
</template>
