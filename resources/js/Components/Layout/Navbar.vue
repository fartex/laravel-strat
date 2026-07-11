<script setup lang="ts">
// ** Local Imports
import Chip from '@shared/Components/Chip.vue';
import Button from '@shared/Components/Button.vue';
import Notification from '@/Components/Layout/Navbar/Notification.vue';
</script>

<template>
  <div class="bg-surface-raised w-full border-b px-4 py-2">
    <div class="flex flex-row items-center justify-between">
      <div class="flex flex-row items-center gap-4">
        <span class="text-lg font-bold"> Strat </span>

        <Chip
          text="v0.0.0"
          color="accent"
        />
      </div>

      <div class="flex flex-row items-center gap-4">
        <Button
          color="accent"
          text="Rodar pendentes"
          icon="fa-solid fa-caret-right"
        />

        <a
          target="_blank"
          class="cursor-pointer"
          href="https://github.com/fartex/laravel-strat"
        >
          <Chip
            text="1.5k"
            icon="fa-brands fa-github"
            class="py-1.5 text-white"
          />
        </a>

        <Notification has-unread />
      </div>
    </div>
  </div>
</template>
