<script setup lang="ts">
defineProps({
  hasUnread: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <div class="relative cursor-pointer">
    <font-awesome-icon icon="fa-solid fa-bell" />

    <span
      v-if="hasUnread"
      class="absolute -top-1 -right-1 flex h-2 w-2"
    >
      <span
        class="bg-accent absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"
      />
      <span class="bg-accent relative inline-flex h-2 w-2 rounded-full" />
    </span>
  </div>
</template>
