<script setup lang="ts">
defineProps({
  breadcrumb: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div class="flex flex-col gap-1 font-mono">
    <span class="text-foreground-muted text-[10px]">
      {{ breadcrumb }}
    </span>

    <div class="flex items-center gap-2">
      <h1 class="text-foreground text-2xl font-bold">
        {{ title }}
      </h1>

      <slot name="subtitle" />
    </div>
  </div>
</template>
