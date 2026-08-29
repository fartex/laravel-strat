<script setup lang="ts">
// ** External Imports
import { computed, onMounted, ref, watch } from 'vue';
import { useHead } from '@unhead/vue';
import axios from 'axios';

// ** Local Imports
import PageHeader from '@shared/Components/PageHeader.vue';
import Tabs from '@/Components/Dashboard/Tabs.vue';
import ConnectionTabs from '@/Components/Dashboard/ConnectionTabs.vue';
import { MigrationStatusEnum } from '@shared/App/enum';
import { Migration } from '@shared/App/types/models';
import Pagination from '@shared/Components/Pagination.vue';
import Table from '@/Components/Dashboard/Table.vue';
import type { TPaginated } from '@shared/App/types/shared';
import MigrationStatus from '@/Components/Dashboard/MigrationStatus.vue';
import Connections from '@/Components/Dashboard/Connections.vue';
import { useRunMigrations } from '@shared/App/composables/useRunMigrations';

useHead({ title: 'Migrations' });

const perPage = 10;

const syncing = ref(false);

const currentPage = ref(1);

const activeTab = ref('all');

const activeDatabase = ref('all');

const migrations = ref<Migration[]>([]);

const pagedMigrations = computed(() => {
  const start = (currentPage.value - 1) * perPage;

  return filteredMigrations.value.slice(start, start + perPage);
});

const dbList = computed(() => [
  ...new Set(migrations.value.map((migration) => migration.database)),
]);

const lastPage = computed(() => Math.max(1, Math.ceil(filteredMigrations.value.length / perPage)));

const counts = computed(() => ({
  total: migrations.value.length,
  executed: migrations.value.filter(
    (migration) => migration.status === MigrationStatusEnum.EXECUTED,
  ).length,
  pending: migrations.value.filter((migration) => migration.status === MigrationStatusEnum.PENDING)
    .length,
}));

const filteredMigrations = computed(() => {
  return migrations.value.filter((migration) => {
    const matchesTab = activeTab.value === 'all' || migration.status === activeTab.value;

    const matchesDatabase =
      activeDatabase.value === 'all' || migration.database === activeDatabase.value;

    return matchesTab && matchesDatabase;
  });
});

const syncMigrations = (): void => {
  syncing.value = true;

  axios
    .get('/sync-migrations')
    .then(() => fetchMigrations())
    .finally(() => {
      setTimeout(() => {
        syncing.value = false;
      }, 3000);
    });
};

const fetchMigrations = () => {
  return axios
    .get<TPaginated<Migration>>('/migrations', { params: { per_page: 10000 } })
    .then((response) => {
      migrations.value = response.data.data;
    })
    .catch(() => {
      migrations.value = [];
    });
};

const { lastRanAt } = useRunMigrations();

onMounted(() => {
  fetchMigrations();
});

watch([activeTab, activeDatabase], () => {
  currentPage.value = 1;
});

watch(lastRanAt, () => {
  fetchMigrations();
});
</script>

<template>
  <PageHeader
    :title="$t('Migrations')"
    breadcrumb="Strat / Migrations"
  />

  <MigrationStatus :counts="counts" />

  <div class="flex flex-col gap-2 py-4">
    <div class="flex flex-row justify-between gap-2">
      <Tabs
        :counts="counts"
        v-model="activeTab"
      />

      <div class="flex gap-3">
        <span
          v-on:click="!syncing && syncMigrations()"
          class="text-success cursor-pointer py-2 text-sm"
        >
          <font-awesome-icon
            class="p-1"
            :spin="syncing"
            icon="fa-solid fa-rotate"
          />
        </span>

        <ConnectionTabs
          :databases="dbList"
          v-model="activeDatabase"
        />
      </div>
    </div>

    <Table :migrations="pagedMigrations" />

    <div class="flex justify-end">
      <Pagination
        v-model="currentPage"
        :last-page="lastPage"
      />
    </div>

    <Connections :migrations="migrations" />
  </div>
</template>
