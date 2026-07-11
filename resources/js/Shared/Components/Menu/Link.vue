<script setup lang="ts">
// ** Local Imports
import Chip from '@shared/Components/Chip.vue';
import type { IMenuLink } from '@shared/App/menu';

defineProps({
  item: {
    type: Object as () => IMenuLink,
    required: true,
  },
});
</script>

<template>
  <router-link
    :to="item.path"
    active-class="bg-accent-subtle text-accent"
    class="text-foreground hover:bg-surface-elevated hover:text-foreground flex items-center gap-2 rounded-md px-3 py-2 text-sm"
  >
    <font-awesome-icon
      v-if="item.icon"
      :icon="item.icon"
      class="w-4"
    />

    <span class="flex-1">{{ item.title }}</span>

    <Chip
      v-if="item.prepend"
      :text="item.prepend.text"
      :color="item.prepend.color"
    />
  </router-link>
</template>
