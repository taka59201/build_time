<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'

// プロップ（Inertiaのコントローラから渡される）
defineProps({ user: Object })

// 基本情報
const profileForm = useForm({
  name:  '',
  email: '',
})
// パスワード
const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})
// 削除確認
const destroyForm = useForm({ password: '' })

// 初期値設定（ページマウント時）
onMounted(() => {
  profileForm.name  = page.props.user?.name  ?? ''
  profileForm.email = page.props.user?.email ?? ''
})
</script>

<template>
  <Head title="Profile" />
  <AppLayout>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- 基本情報 -->
      <div class="bg-white rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Account Information</h2>
        <form @submit.prevent="profileForm.patch(route('profile.update'))" class="space-y-3">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Name</label>
            <input v-model="profileForm.name" type="text" class="w-full border p-2 rounded" />
            <p v-if="profileForm.errors.name" class="text-red-600 text-sm mt-1">
              {{ profileForm.errors.name }}
            </p>
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input v-model="profileForm.email" type="email" class="w-full border p-2 rounded" />
            <p v-if="profileForm.errors.email" class="text-red-600 text-sm mt-1">
              {{ profileForm.errors.email }}
            </p>
          </div>
          <div class="pt-2">
            <button type="submit" :disabled="profileForm.processing"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
              Update Profile
            </button>
          </div>
        </form>
      </div>

      <!-- パスワード変更 -->
      <div class="bg-white rounded shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Change Password</h2>
        <form @submit.prevent="passwordForm.put(route('password.update'))" class="space-y-3">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Current Password</label>
            <input v-model="passwordForm.current_password" type="password"
                   class="w-full border p-2 rounded" autocomplete="current-password" />
            <p v-if="passwordForm.errors.current_password" class="text-red-600 text-sm mt-1">
              {{ passwordForm.errors.current_password }}
            </p>
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">New Password</label>
            <input v-model="passwordForm.password" type="password"
                   class="w-full border p-2 rounded" autocomplete="new-password" />
            <p v-if="passwordForm.errors.password" class="text-red-600 text-sm mt-1">
              {{ passwordForm.errors.password }}
            </p>
          </div>
          <div>
            <label class="block text-sm text-gray-600 mb-1">Confirm Password</label>
            <input v-model="passwordForm.password_confirmation" type="password"
                   class="w-full border p-2 rounded" autocomplete="new-password" />
          </div>
          <div class="pt-2">
            <button type="submit" :disabled="passwordForm.processing"
                    class="bg-emerald-600 text-white px-4 py-2 rounded">
              Update Password
            </button>
          </div>
        </form>
      </div>

      <!-- アカウント削除 -->
      <div class="bg-white rounded shadow p-6 lg:col-span-2">
        <h2 class="text-lg font-semibold mb-2 text-red-700">Delete Account</h2>
        <p class="text-sm text-gray-600 mb-4">This action is permanent.</p>

        <form @submit.prevent="destroyForm.delete(route('profile.destroy'))" class="space-y-3">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Password</label>
            <input v-model="destroyForm.password" type="password" class="w-full border p-2 rounded"
                   placeholder="Confirm with your password" />
            <p v-if="destroyForm.errors.password" class="text-red-600 text-sm mt-1">
              {{ destroyForm.errors.password }}
            </p>
          </div>
          <button type="submit" :disabled="destroyForm.processing"
                  class="bg-red-600 text-white px-4 py-2 rounded">
            Delete Account
          </button>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
const page = usePage()
export default {}
</script>

