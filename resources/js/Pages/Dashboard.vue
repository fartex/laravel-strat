<script setup lang="ts">
// ** External Imports
import { computed, onMounted, ref } from 'vue';
import { useHead } from '@unhead/vue';
import axios from 'axios';

// ** Local Imports
import PageHeader from '@shared/Components/PageHeader.vue';
import Tabs from '@/Components/Dashboard/Tabs.vue';
import { Migration } from '@shared/App/types/models';
import Button from '@shared/Components/Button.vue';
import { useDatabaseStatus } from '@shared/App/composables/useDatabaseStatus';
import Table from '@/Components/Dashboard/Table.vue';

useHead({ title: 'Migrations' });

const activeTab = ref('all');

const activeConnection = ref('all');

const migrations = ref<Migration[]>([]);

const { connections } = useDatabaseStatus();

const dbList = computed(() => connections.value.map((connection) => connection.name));

const fetchMigrations = (): void => {
  axios
    .get<Migration[]>('/migrations')
    .then((response) => {
      migrations.value = response.data;
    })
    .catch(() => {
      migrations.value = [];
    });
};

onMounted(() => {
  fetchMigrations();
});
</script>

<template>
  <PageHeader
    :title="$t('Migrations')"
    breadcrumb="Strat / Migrations"
  />

  <div class="flex flex-row gap-1 py-1 text-xs">
    <span> 13 no total </span>
    ·
    <span class="text-success"> 9 executadas </span>
    ·
    <span class="text-accent"> 4 pendentes </span>
  </div>

  <div class="flex flex-col gap-2 py-4">
    <div class="flex flex-row justify-between gap-2">
      <Tabs v-model="activeTab" />

      <div class="flex">
        <Button
          color="accent"
          class="text-xs"
          variant="outline"
          :text="$t('All Connections')"
        />
      </div>
    </div>

    <Table :migrations="migrations" />
  </div>
</template>
