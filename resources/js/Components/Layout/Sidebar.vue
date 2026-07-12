<script setup lang="ts">
// ** Local Imports
import { menu } from '@shared/App/menu';
import Menu from '@shared/Components/Menu/Index.vue';
</script>

<template>
  <div class="bg-surface-raised w-60 border-r p-4">
    <div class="flex h-full flex-col justify-between">
      <Menu :items="menu('admin')" />

      <div class="flex flex-col gap-2">
        <span class="border" />

        <span class="text-foreground-muted text-xs uppercase">
          {{ $t('Database') }}
        </span>

        <div class="flex py-1 text-xs">
          <span class="text-success mr-1 animate-pulse">
            <font-awesome-icon
              size="xs"
              icon="fa-solid fa-circle"
            />
          </span>

          <div class="flex flex-col">
            strap_app

            <span class="text-foreground-muted text-[10px]"> MySQL </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
