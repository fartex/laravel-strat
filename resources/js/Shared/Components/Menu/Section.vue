<script setup lang="ts">
// ** Local Imports
import type { IMenuSection } from '@shared/App/menu';

defineProps({
  item: {
    type: Object as () => IMenuSection,
    required: true,
  },
});
</script>

<template>
  <div class="text-foreground-muted px-3 pt-4 pb-1 text-xs font-semibold uppercase">
    {{ item.section }}
  </div>
</template>
