<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})
const submit = () => form.post('/login')
</script>

<template>
  <Head title="Login" />
  <GuestLayout>
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Login</h2>

      <form @submit.prevent="submit" class="space-y-3">
        <input v-model="form.email" type="email" placeholder="Email"
               class="w-full border p-2 rounded" autocomplete="email" required />
        <input v-model="form.password" type="password" placeholder="Password"
               class="w-full border p-2 rounded" autocomplete="current-password" required />
        <label class="flex items-center gap-2 text-sm">
          <input type="checkbox" v-model="form.remember" />
          Remember me
        </label>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded"
                :disabled="form.processing">
          Sign in
        </button>

        <div class="text-sm text-center mt-2">
          <Link href="/register" class="text-blue-600 hover:underline">Create account</Link>
        </div>
      </form>
    </div>
  </GuestLayout>
</template>

