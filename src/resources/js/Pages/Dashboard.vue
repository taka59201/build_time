<template>
    <div class="min-h-screen bg-gray-100 p-6">
        <!-- ヘッダー -->
        <header class="bg-white shadow p-4 flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <div class="text-sm text-gray-500">Last updated: {{ lastUpdated }}</div>
        </header>

        <!-- 統計カード -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div v-for="stat in stats" :key="stat.label" class="bg-white rounded shadow p-4">
                <div class="text-gray-500 text-sm">{{ stat.label }}</div>
                <div class="text-2xl font-bold">{{ stat.value }}</div>
                <div class="text-xs text-green-500" v-if="stat.trend > 0">▲ {{ stat.trend }}%</div>
                <div class="text-xs text-red-500" v-else>▼ {{ stat.trend }}%</div>
            </div>
        </div>

        <!-- 大量テーブル -->
        <div class="bg-white rounded shadow p-4 overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">Recent Activities</h2>
            <table class="min-w-full text-sm">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Action</th>
                    <th class="px-4 py-2 text-left">Date</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in rows" :key="row.id" class="border-b">
                    <td class="px-4 py-2">{{ row.id }}</td>
                    <td class="px-4 py-2">{{ row.user }}</td>
                    <td class="px-4 py-2">{{ row.action }}</td>
                    <td class="px-4 py-2">{{ row.date }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- グリッドカード -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-6 gap-4">
            <div v-for="n in 60" :key="n" class="bg-white h-24 rounded shadow flex items-center justify-center">
                Card {{ n }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

// 重い統計計算サンプル
const stats = ref([])
const lastUpdated = ref(new Date().toLocaleString())

function generateStats() {
    const labels = ['Users', 'Sales', 'Orders', 'Visits']
    stats.value = labels.map(label => ({
        label,
        value: Math.floor(Math.random() * 10000),
        trend: (Math.random() * 20 - 10).toFixed(1)
    }))
}

// 大量のテーブルデータを生成
const rows = ref([])
function generateRows() {
    rows.value = Array.from({ length: 5000 }).map((_, i) => ({
        id: i + 1,
        user: `User_${i + 1}`,
        action: ['Login', 'Purchase', 'Logout'][Math.floor(Math.random() * 3)],
        date: new Date(Date.now() - Math.random() * 1e10).toLocaleDateString()
    }))
}

onMounted(() => {
    generateStats()
    generateRows()
})
</script>
