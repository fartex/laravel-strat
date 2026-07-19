<script setup lang="ts">
// ** External Imports
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

// ** Local Imports
import { Migration } from '@shared/App/types/models';
import { useDatabaseStatus } from '@shared/App/composables/useDatabaseStatus';
import { DatabaseDriverEnum, MigrationStatusEnum } from '@shared/App/enum';
import { DatabaseDriverValues } from '@shared/App/enum/values';
import type { TColor, TDatabaseConnectionStatus } from '@shared/App/types/shared';

const props = defineProps({
  migrations: {
    required: true,
    type: Object as () => Migration[],
  },
});

const { t } = useI18n();

const { connections } = useDatabaseStatus();

const driverColors: Record<string, TColor> = {
  [DatabaseDriverEnum.MYSQL]: 'warning',
  [DatabaseDriverEnum.PGSQL]: 'info',
  [DatabaseDriverEnum.SQLITE]: 'accent',
  [DatabaseDriverEnum.SQLSRV]: 'danger',
};

const driverInitials: Record<string, string> = {
  [DatabaseDriverEnum.MYSQL]: 'My',
  [DatabaseDriverEnum.PGSQL]: 'Pg',
  [DatabaseDriverEnum.SQLITE]: 'Sq',
  [DatabaseDriverEnum.SQLSRV]: 'Ms',
};

const badgeColorClasses: Record<TColor, string> = {
  info: 'text-info bg-info/15',
  danger: 'text-danger bg-danger/15',
  accent: 'text-accent bg-accent/15',
  success: 'text-success bg-success/15',
  warning: 'text-warning bg-warning/15',
};

// Sqlite stores an absolute file path; migrations are recorded under just the file name.
function resolveDatabaseName(connection: TDatabaseConnectionStatus): string {
  if (!connection.database) {
    return connection.name;
  }

  if (connection.driver === DatabaseDriverEnum.SQLITE && connection.database !== ':memory:') {
    return connection.database.split('/').pop() ?? connection.database;
  }

  return connection.database;
}

const databases = computed(() => {
  return connections.value.map((connection) => {
    const databaseName = resolveDatabaseName(connection);

    const databaseMigrations = props.migrations.filter(
      (migration) => migration.database === databaseName,
    );

    const executed = databaseMigrations.filter(
      (migration) => migration.status === MigrationStatusEnum.EXECUTED,
    ).length;

    return {
      executed,
      connection,
      databaseName,
      total: databaseMigrations.length,
      pending: databaseMigrations.length - executed,
    };
  });
});

function driverLabel(driver: string | null): string {
  const match = DatabaseDriverValues.find((item) => item.value === driver);

  return match ? t(match.title) : (driver ?? t('Unknown'));
}

function progress(item: { total: number; executed: number }): number {
  return item.total === 0 ? 0 : Math.round((item.executed / item.total) * 100);
}

function driverBadgeClass(driver: string | null): string {
  return badgeColorClasses[driverColors[driver ?? '']] ?? 'text-foreground-muted bg-surface-inset';
}
</script>

<template>
  <div class="flex flex-col gap-1">
    <span class="text-foreground-muted text-xs font-semibold uppercase">
      {{ $t('Database Connected') }}
    </span>

    <div class="flex flex-col gap-2">
      <div
        v-for="item in databases"
        :key="item.connection.name"
        class="flex flex-row items-center justify-between gap-4 rounded-lg border p-3"
      >
        <div class="flex flex-row items-center gap-3">
          <span
            :class="driverBadgeClass(item.connection.driver)"
            class="flex h-8 w-8 items-center justify-center rounded-md text-[10px] font-bold"
          >
            {{ driverInitials[item.connection.driver ?? ''] ?? '?' }}
          </span>

          <div class="flex flex-col">
            <span class="text-sm font-semibold">
              {{ item.databaseName }}
            </span>

            <span class="text-foreground-muted text-[11px]">
              {{ driverLabel(item.connection.driver) }}
            </span>
          </div>
        </div>

        <div class="flex flex-row items-center gap-4 text-xs">
          <span class="text-success">
            {{ $t('migrations.executed', { count: item.executed }) }}
          </span>

          <span class="text-warning">
            {{ $t('migrations.pending', { count: item.pending }) }}
          </span>

          <span class="text-foreground-muted">
            {{ $t('migrations.total', { count: item.total }) }}
          </span>

          <div class="bg-surface-inset flex h-1.5 w-24 overflow-hidden rounded-full">
            <span
              class="bg-success h-full"
              :style="{ width: progress(item) + '%' }"
            />
            <span
              class="bg-warning h-full"
              :style="{ width: 100 - progress(item) + '%' }"
            />
          </div>

          <span :class="['animate-pulse', item.connection.online ? 'text-success' : 'text-danger']">
            <font-awesome-icon icon="fa-solid fa-circle" />
            {{ $t(item.connection.online ? 'Connected' : 'Disconnected') }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
