<script setup lang="ts">
  import { useAuthStore } from "@/stores/auth";
  import { useRouter } from "vue-router";
  import SignOutIcon from "@/assets/icons/sign-out.svg?component";
  import ListMagnifyingGlassIcon from "@/assets/icons/list-magnifying-glass.svg?component";

  const authStore = useAuthStore();
  const router = useRouter();

  function logout() {
    authStore.logout();
    router.push("/login");
  }
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <header 
      class="
        w-full h-14 px-6 
        flex items-center justify-between 
        bg-white shadow-sm 
        border-b border-gray-200
      "
    >
      <div class="flex flex-row justify-start items-center space-x-2">
        <ListMagnifyingGlassIcon class="w-6 h-6 fill-gray-700" />
        <h1 class="text-lg font-semibold text-gray-700 tracking-tight">
          CRUD Pessoas
        </h1>
      </div>

      <div class="flex items-center gap-3">
        <button
          @click="logout"
          class="
            flex flex-row items-center gap-2
            px-3 py-1 rounded-md
            bg-red-50 text-red-500 
            border border-red-500 
            hover:bg-red-100
            transition-all duration-150 
            cursor-pointer text-sm font-medium
          "
        >
          <SignOutIcon class="w-4 h-4 fill-red-500" />
          Sair
        </button>
      </div>
    </header>

    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>