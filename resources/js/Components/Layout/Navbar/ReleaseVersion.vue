<script setup lang="ts">
// ** External Imports
import { onMounted, ref } from 'vue';
import axios from 'axios';

// ** Local Imports
import Chip from '@shared/Components/Chip.vue';

interface ReleaseResponse {
  tag_name: string;
}

const version = ref<string | null>(null);

onMounted(() => {
  axios
    .get<ReleaseResponse>('https://api.github.com/repos/fartex/laravel-strat/releases/latest')
    .then((response) => {
      version.value = response.data.tag_name;
    })
    .catch(() => {});
});
</script>

<template>
  <Chip
    v-if="version"
    :text="version"
    color="accent"
  />
</template>
