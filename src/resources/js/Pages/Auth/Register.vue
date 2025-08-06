<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})
const submit = () => form.post('/register')
</script>

<template>
  <Head title="Register" />
  <GuestLayout>
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Register</h2>

      <form @submit.prevent="submit" class="space-y-3">
        <input v-model="form.name" type="text" placeholder="Name"
               class="w-full border p-2 rounded" autocomplete="name" required />
        <input v-model="form.email" type="email" placeholder="Email"
               class="w-full border p-2 rounded" autocomplete="email" required />
        <input v-model="form.password" type="password" placeholder="Password"
               class="w-full border p-2 rounded" autocomplete="new-password" required />
        <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password"
               class="w-full border p-2 rounded" autocomplete="new-password" required />

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded"
                :disabled="form.processing">
          Create account
        </button>

        <div class="text-sm text-center mt-2">
          <Link href="/login" class="text-blue-600 hover:underline">I already have an account</Link>
        </div>
      </form>
    </div>
  </GuestLayout>
</template>

