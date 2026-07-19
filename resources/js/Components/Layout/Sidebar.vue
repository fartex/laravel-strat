<script setup lang="ts">
// ** Local Imports
import { menu } from '@shared/App/menu';
import Menu from '@shared/Components/Menu/Index.vue';
import DatabaseStatus from '@/Components/Layout/Sidebar/DatabaseStatus.vue';
</script>

<template>
  <div class="bg-surface-raised w-52 border-r p-4">
    <div class="flex h-full flex-col justify-between">
      <Menu :items="menu('admin')" />

      <DatabaseStatus />
    </div>
  </div>
</template>
