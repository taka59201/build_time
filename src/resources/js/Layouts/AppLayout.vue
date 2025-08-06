<!-- resources/js/Layouts/AppLayout.vue -->
<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- ===== Sidebar ===== -->
    <aside
      :class="[
        'bg-gray-900 text-gray-100 fixed inset-y-0 z-40 transition-all duration-200',
        sidebarOpen ? 'w-64 translate-x-0' : 'w-64 -translate-x-full',
        'md:translate-x-0 md:static md:block'
      ]"
      aria-label="Sidebar"
    >
      <div class="h-14 flex items-center justify-between px-4 border-b border-gray-800">
        <span class="font-bold">My Admin</span>
        <button class="md:hidden p-2 rounded hover:bg-gray-800" @click="toggleSidebar" aria-label="Close sidebar">✕</button>
      </div>

      <nav class="py-3 text-sm">
        <!-- Dashboard -->
        <Link
          href="/dashboard"
          :class="navClass('/dashboard')"
          @click="closeSidebarOnMobile"
        >
          <span class="w-5 text-center">🏠</span>
          <span>Dashboard</span>
        </Link>

        <!-- Users -->
        <Link
          href="/users"
          :class="navClass('/users')"
          @click="closeSidebarOnMobile"
        >
          <span class="w-5 text-center">👤</span>
          <span>Users</span>
        </Link>
      </nav>
    </aside>

    <!-- Backdrop for mobile -->
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 bg-black/40 z-30 md:hidden"
      @click="toggleSidebar"
    ></div>

    <!-- ===== Main ===== -->
    <div class="flex-1 flex flex-col min-w-0 md:ml-64">
      <!-- Header -->
      <header class="bg-white border-b">
        <div class="h-14 max-w-7xl mx-auto px-4 flex items-center justify-between gap-2">
          <div class="flex items-center gap-2">
            <button class="md:hidden p-2 rounded border" @click="toggleSidebar" aria-label="Open sidebar">☰</button>
            <h1 class="font-semibold">Admin Panel</h1>
          </div>

          <!-- Right actions -->
          <div class="flex items-center gap-4">
            <!-- Authenticated -->
            <template v-if="currentUser">
              <div class="relative" ref="profileMenuRef">
                <button
                  class="flex items-center gap-2 text-sm px-3 py-1.5 rounded hover:bg-gray-100"
                  @click="menuOpen = !menuOpen"
                  :aria-expanded="menuOpen"
                  aria-haspopup="menu"
                >
                  <span class="inline-grid place-items-center size-8 rounded-full bg-gray-200">👤</span>
                  <span class="hidden sm:inline text-gray-700">{{ currentUser.name }}</span>
                  <span class="text-gray-500">▾</span>
                </button>

                <div
                  v-if="menuOpen"
                  class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded border z-50"
                  role="menu"
                >
                  <Link
                    href="/profile"
                    class="block px-3 py-2 hover:bg-gray-50 text-sm"
                    role="menuitem"
                    @click="closeMenus"
                  >Profile</Link>

                  <button
                    type="button"
                    class="w-full text-left px-3 py-2 hover:bg-gray-50 text-sm border-t"
                    role="menuitem"
                    @click="logout"
                  >Logout</button>
                </div>
              </div>
            </template>

            <!-- Guest -->
            <template v-else>
              <Link href="/login" class="text-blue-600 hover:underline text-sm">Login</Link>
              <Link href="/register" class="text-green-600 hover:underline text-sm">Register</Link>
            </template>
          </div>
        </div>
      </header>

      <!-- Content -->
      <main class="max-w-7xl mx-auto w-full p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed, onMounted, onBeforeUnmount, ref } from 'vue'

const page = usePage()
const currentUser = computed(() => page.props.auth?.user ?? null)

const sidebarOpen = ref(false)
const menuOpen = ref(false)
const profileMenuRef = ref(null)

function toggleSidebar() { sidebarOpen.value = !sidebarOpen.value }
function closeSidebarOnMobile() { if (window.innerWidth < 768) sidebarOpen.value = false }
function closeMenus() { menuOpen.value = false }
function onClickOutside(e) {
  if (!profileMenuRef.value) return
  if (!profileMenuRef.value.contains(e.target)) menuOpen.value = false
}
onMounted(() => document.addEventListener('click', onClickOutside))
onBeforeUnmount(() => document.removeEventListener('click', onClickOutside))

// 現在URLの先頭一致で active を判定
function isActive(prefix) { return page.url.startsWith(prefix) }
function navClass(prefix) {
  return [
    'flex items-center gap-3 px-4 py-2',
    isActive(prefix) ? 'bg-gray-800 text-white' : 'text-gray-200 hover:bg-gray-800 hover:text-white'
  ]
}

// Inertia で POST /logout
function logout() {
  router.post('/logout', {}, { onFinish: () => (menuOpen.value = false) })
}
</script>

<style scoped>
/* 必要なら細かな調整を追加 */
</style>

