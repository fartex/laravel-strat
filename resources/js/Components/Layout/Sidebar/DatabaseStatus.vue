<script setup lang="ts">
// ** External Imports
import { useI18n } from 'vue-i18n';

// ** Local Imports
import { useDatabaseStatus } from '@shared/App/composables/useDatabaseStatus';
import { DatabaseDriverEnum } from '@shared/App/enum';
import { DatabaseDriverValues } from '@shared/App/enum/values';
import { TDatabaseConnectionStatus } from '@shared/App/types/shared';

const { t } = useI18n();

const { connections } = useDatabaseStatus();

const driverLabel = (driver: string | null): string => {
  const match = DatabaseDriverValues.find((item) => item.value === driver);

  return match ? t(match.title) : (driver ?? t('Unknown'));
};

function getDatabase(connection: TDatabaseConnectionStatus): string {
  if (!connection.database) {
    return '—';
  }

  // Sqlite stores an absolute file path; show just the file name.
  if (connection.driver === DatabaseDriverEnum.SQLITE && connection.database !== ':memory:') {
    return connection.database.split('/').pop() ?? connection.database;
  }

  return connection.database;
}
</script>

<template>
  <div class="flex flex-col gap-2">
    <span class="border" />

    <span class="text-foreground-muted text-xs uppercase">
      {{ $t('Database') }}
    </span>

    <div
      class="flex py-1 text-xs"
      :key="connection.name"
      v-for="connection in connections"
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
        {{ getDatabase(connection) }}

        <span class="text-foreground-muted text-[10px]">
          {{ driverLabel(connection.driver) }}
        </span>
      </div>
    </div>
  </div>
</template>
