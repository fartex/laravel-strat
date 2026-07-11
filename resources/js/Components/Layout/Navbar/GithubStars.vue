<script setup lang="ts">
// ** External Imports
import { onMounted, ref } from 'vue';
import axios from 'axios';

// ** Local Imports
import Chip from '@shared/Components/Chip.vue';

interface RepoResponse {
  stargazers_count: number;
}

const stars = ref<string | null>(null);

const formatStars = (count: number): string => {
  if (count >= 1000) {
    return `${(count / 1000).toFixed(1)}k`;
  }

  return `${count}`;
};

onMounted(() => {
  axios.get<RepoResponse>('https://api.github.com/repos/fartex/laravel-strat').then((response) => {
    stars.value = formatStars(response.data.stargazers_count);
  });
});
</script>

<template>
  <a
    target="_blank"
    class="cursor-pointer"
    href="https://github.com/fartex/laravel-strat"
  >
    <Chip
      :text="stars ?? '0'"
      class="py-1.5 text-white"
      icon="fa-brands fa-github"
    />
  </a>
</template>
