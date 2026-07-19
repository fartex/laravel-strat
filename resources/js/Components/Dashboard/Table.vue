<script setup lang="ts">
// ** External Imports
import { useI18n } from 'vue-i18n';

// ** Local Imports
import Button from '@shared/Components/Button.vue';
import { MigrationStatusEnum } from '@shared/App/enum';
import { MigrationStatusValues, MigrationTypeValues } from '@shared/App/enum/values';
import { MigrationTable } from '@shared/App/types/tables';
import { Migration } from '@shared/App/types/models';
import type { TColor } from '@shared/App/types/shared';
import Chip from '@shared/Components/Chip.vue';
import { useRunMigrations } from '@shared/App/composables/useRunMigrations';

defineProps({
  migrations: {
    required: true,
    type: Object as () => Migration[],
  },
});

const emit = defineEmits(['ran']);

const { t } = useI18n();

const { runningIds, runMigrations } = useRunMigrations();

const statusTextClasses: Record<TColor, string> = {
  info: 'text-info',
  danger: 'text-danger',
  accent: 'text-accent',
  success: 'text-success',
  warning: 'text-warning',
};

const runMigration = (id: number): void => {
  runMigrations(id).finally(() => emit('ran'));
};

function formatBatch(value: number | null): string {
  return value === null ? '—' : String(value);
}

function formatDuration(value: number | null): string {
  return value === null ? '—' : `${value} ms`;
}

function formatExecutedAt(value: string | null): string {
  if (!value) {
    return '—';
  }

  const date = new Date(value.replace(' ', 'T'));

  const day = String(date.getDate()).padStart(2, '0');

  const month = t(`month.${date.getMonth()}`);

  const hours = String(date.getHours()).padStart(2, '0');

  const minutes = String(date.getMinutes()).padStart(2, '0');

  return `${day} ${month}, ${hours}:${minutes}`;
}

function statusMeta(status: string) {
  return MigrationStatusValues.find((item) => item.value === status);
}

function truncate(value: string, length: number): string {
  return value.length > length ? `${value.slice(0, length)}…` : value;
}

function migrationTypeColor(type: string): TColor {
  return MigrationTypeValues.find((item) => item.value === type)?.color ?? 'info';
}
</script>

<template>
  <div class="my-4 overflow-x-auto rounded-lg">
    <table class="w-full min-w-275 text-left">
      <thead>
        <tr class="border-border-subtle border-b">
          <th
            :key="column.key"
            v-for="column in MigrationTable"
            class="text-foreground-muted px-4 py-2 text-xs font-medium tracking-wide uppercase"
          >
            {{ $t(column.title) }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr
          :key="migration.id"
          v-for="migration in migrations"
          class="border-border-subtle hover:bg-surface-raised border-b transition-colors last:border-b-0"
        >
          <td class="px-4 py-3">
            <span
              :class="[
                'inline-flex items-center gap-1.5 text-xs font-medium',
                statusTextClasses[statusMeta(migration.status)?.color ?? 'info'],
              ]"
            >
              <font-awesome-icon
                size="xs"
                icon="fa-solid fa-circle"
              />

              {{ $t(statusMeta(migration.status)?.title ?? '') }}
            </span>
          </td>

          <td class="text-foreground px-4 py-3 font-mono text-xs">
            <span :title="migration.migration">
              {{ truncate(migration.migration, 50) }}
            </span>
          </td>

          <td class="px-1 py-3">
            <Chip
              :color="migrationTypeColor(migration.type)"
              :text="$t(`enum.migration_type.${migration.type}`)"
            />
          </td>

          <td class="text-foreground-muted px-4 py-3 font-mono text-xs">
            <span :title="migration.table">
              {{ truncate(migration.table, 30) }}
            </span>
          </td>

          <td class="text-foreground-muted px-4 py-3 font-mono text-xs">
            <span :title="migration.database">
              {{ truncate(migration.database, 20) }}
            </span>
          </td>

          <td
            :class="[
              'px-4 py-3 font-mono text-xs',
              migration.batch === null ? 'text-foreground-muted' : 'text-foreground font-semibold',
            ]"
          >
            {{ formatBatch(migration.batch) }}
          </td>

          <td class="text-foreground-muted px-4 py-3 text-xs">
            {{ formatExecutedAt(migration.executed_at) }}
          </td>

          <td class="text-foreground-muted px-4 py-3 font-mono text-xs">
            {{ formatDuration(migration.duration_ms) }}
          </td>

          <td class="px-4 py-3 text-right">
            <Button
              color="accent"
              :text="$t('Run')"
              icon="fa-solid fa-caret-right"
              :spin="runningIds.has(migration.id)"
              v-on:click="runMigration(migration.id)"
              :disabled="runningIds.has(migration.id)"
              v-if="migration.status === MigrationStatusEnum.PENDING"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
