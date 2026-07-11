<script setup lang="ts">
// ** Local Imports
import Navbar from '../Components/Layout/Navbar.vue';
import Sidebar from '../Components/Layout/Sidebar.vue';
</script>

<template>
  <div class="bg-primary text-foreground flex h-screen flex-col">
    <Navbar />

    <div class="flex flex-1 overflow-hidden">
      <Sidebar />

      <main class="flex-1 overflow-y-auto p-6">
        <router-view />
      </main>
    </div>
  </div>
</template>
