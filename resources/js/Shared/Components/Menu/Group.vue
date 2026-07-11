<script setup lang="ts">
// ** External Imports
import { useMenuGroups } from '@shared/App/composables/useMenuGroups';

// ** Local Imports
import Chip from '@shared/Components/Chip.vue';
import Index from './Index.vue';
import type { IMenuGroup } from '@shared/App/menu';

defineProps({
  item: {
    type: Object as () => IMenuGroup,
    required: true,
  },
});

const { isOpen, toggleGroup } = useMenuGroups();
</script>

<template>
  <div>
    <button
      type="button"
      class="text-foreground-muted hover:bg-surface-elevated hover:text-foreground flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm"
      @click="toggleGroup(item.id)"
    >
      <font-awesome-icon
        v-if="item.icon"
        :icon="item.icon"
        class="w-4"
      />

      <span class="flex-1 text-left">{{ item.title }}</span>

      <Chip
        v-if="item.prepend"
        :text="item.prepend.text"
        :color="item.prepend.color"
      />

      <font-awesome-icon
        class="transition-transform"
        icon="fa-solid fa-caret-right"
        :class="{ 'rotate-90': isOpen(item.id) }"
      />
    </button>

    <Index
      v-if="isOpen(item.id)"
      class="mt-1 pl-4"
      :items="item.options"
    />
  </div>
</template>
