<script setup lang="ts">
// ** Local Imports
import { useDatabaseStatus } from '@shared/App/composables/useDatabaseStatus';
import { DatabaseDriverValues } from '@shared/App/enum/values';

const { connections } = useDatabaseStatus();

const driverLabel = (driver: string | null): string =>
  driver ? (DatabaseDriverValues[driver as keyof typeof DatabaseDriverValues] ?? driver) : '';
</script>

<template>
  <div class="flex flex-col gap-2">
    <span class="border" />

    <span class="text-foreground-muted text-xs uppercase">
      {{ $t('Database') }}
    </span>

    <div
      class="flex py-1 text-xs"
      v-for="connection in connections"
      :key="connection.name"
    >
      <span
        class="mr-1 animate-pulse"
        :class="connection.online ? 'text-success' : 'text-danger'"
      >
        <font-awesome-icon
          size="xs"
          icon="fa-solid fa-circle"
        />
      </span>

      <div class="flex flex-col">
        {{ connection.name }}

        <span class="text-foreground-muted text-[10px]">
          {{ driverLabel(connection.driver) }}
        </span>
      </div>
    </div>
  </div>
</template>
