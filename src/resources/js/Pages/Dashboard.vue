<template>
    <div class="min-h-screen bg-gray-100 p-6">
        <!-- ヘッダー -->
        <header class="bg-white shadow p-4 flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <div class="text-sm text-gray-500">Last updated: {{ lastUpdated }}</div>
        </header>

        <!-- グラフ群 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-2">Sales Over Time</h2>
                <canvas ref="lineChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-2">Product Distribution</h2>
                <canvas ref="pieChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-2">Monthly Revenue</h2>
                <canvas ref="barChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-2">Performance Radar</h2>
                <canvas ref="radarChart"></canvas>
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
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {
    Chart, LineController, LineElement, PointElement, LinearScale, Title,
    CategoryScale, ArcElement, BarElement, BarController, PieController,
    RadarController, RadialLinearScale
} from 'chart.js'

// Chart.js 登録
Chart.register(
    LineController, LineElement, PointElement, LinearScale, Title, CategoryScale,
    ArcElement, BarElement, BarController, PieController, RadarController, RadialLinearScale
)

const lastUpdated = ref(new Date().toLocaleString())

// グラフ用の ref
const lineChart = ref(null)
const pieChart = ref(null)
const barChart = ref(null)
const radarChart = ref(null)

// 表データ
const rows = ref([])

function generateRows() {
    rows.value = Array.from({ length: 2000 }).map((_, i) => ({
        id: i + 1,
        user: `User_${i + 1}`,
        action: ['Login', 'Purchase', 'Logout'][Math.floor(Math.random() * 3)],
        date: new Date(Date.now() - Math.random() * 1e10).toLocaleDateString()
    }))
}

function randomData(count, min = 0, max = 100) {
    return Array.from({ length: count }).map(() => Math.floor(Math.random() * (max - min + 1)) + min)
}

onMounted(() => {
    generateRows()

    new Chart(lineChart.value, {
        type: 'line',
        data: {
            labels: Array.from({ length: 12 }).map((_, i) => `Month ${i + 1}`),
            datasets: [{
                label: 'Sales',
                data: randomData(12, 100, 1000),
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            }]
        }
    })

    new Chart(pieChart.value, {
        type: 'pie',
        data: {
            labels: ['Product A', 'Product B', 'Product C'],
            datasets: [{
                data: randomData(3, 100, 500),
                backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
            }]
        }
    })

    new Chart(barChart.value, {
        type: 'bar',
        data: {
            labels: Array.from({ length: 12 }).map((_, i) => `Month ${i + 1}`),
            datasets: [{
                label: 'Revenue',
                data: randomData(12, 1000, 5000),
                backgroundColor: '#4BC0C0'
            }]
        }
    })

    new Chart(radarChart.value, {
        type: 'radar',
        data: {
            labels: ['Quality', 'Speed', 'Support', 'Features', 'Usability'],
            datasets: [{
                label: 'Score',
                data: randomData(5, 50, 100),
                backgroundColor: 'rgba(179,181,198,0.2)',
                borderColor: 'rgba(179,181,198,1)'
            }]
        }
    })
})
</script>
