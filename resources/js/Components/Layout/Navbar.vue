<script setup lang="ts">
// ** Local Imports
import Chip from '@shared/Components/Chip.vue';
import Button from '@shared/Components/Button.vue';
import Notification from '@/Components/Layout/Navbar/Notification.vue';
import GithubStars from '@/Components/Layout/Navbar/GithubStars.vue';
import { useRunMigrations } from '@shared/App/composables/useRunMigrations';
import logo from '@images/favicon.png';

const { runningAll, runMigrations } = useRunMigrations();
</script>

<template>
  <div class="bg-surface-raised w-full border-b px-4 py-2">
    <div class="flex flex-row items-center justify-between">
      <div class="flex flex-row items-center gap-4">
        <img
          :src="logo"
          alt="Strat"
          class="h-8 w-8"
        />

        <Chip
          text="v0.0.0"
          color="accent"
        />
      </div>

      <div class="flex flex-row items-center gap-4">
        <Button
          color="accent"
          :spin="runningAll"
          :disabled="runningAll"
          :text="$t('Run Pendents')"
          icon="fa-solid fa-caret-right"
          v-on:click="runMigrations()"
        />

        <GithubStars />

        <!--        <Notification has-unread />-->
      </div>
    </div>
  </div>
</template>
