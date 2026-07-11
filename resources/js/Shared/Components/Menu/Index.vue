<script setup lang="ts">
// ** Local Imports
import Group from './Group.vue';
import Section from './Section.vue';
import Link from './Link.vue';
import type { IMenuItems } from '@shared/App/menu';

defineProps({
  items: {
    type: Array as () => IMenuItems,
    required: true,
  },
});
</script>

<template>
  <ul class="flex flex-col gap-1">
    <li
      v-for="item in items"
      :key="item.id"
    >
      <Group
        v-if="'options' in item"
        :item="item"
      />

      <Section
        v-else-if="'section' in item"
        :item="item"
      />

      <Link
        v-else
        :item="item"
      />
    </li>
  </ul>
</template>
