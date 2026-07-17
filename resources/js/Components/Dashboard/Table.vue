<script setup lang="ts">
import { Migration } from '@shared/App/types/models';

defineProps({
  migrations: {
    required: true,
    type: Object as () => Migration[],
  },
});
</script>

<template>
  {{ migrations }}
</template>
