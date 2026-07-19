<script setup lang="ts">
// ** External Imports
import { computed } from 'vue';

const props = defineProps({
  modelValue: {
    type: Number,
    required: true,
  },
  lastPage: {
    type: Number,
    required: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const pages = computed<(number | '...')[]>(() => {
  if (props.lastPage <= 1) {
    return [1];
  }

  const delta = 1;
  const left = Math.max(2, props.modelValue - delta);
  const right = Math.min(props.lastPage - 1, props.modelValue + delta);

  const range: (number | '...')[] = [1];

  if (left > 2) {
    range.push('...');
  }

  for (let page = left; page <= right; page++) {
    range.push(page);
  }

  if (right < props.lastPage - 1) {
    range.push('...');
  }

  range.push(props.lastPage);

  return range;
});

function go(page: number) {
  if (page < 1 || page > props.lastPage || page === props.modelValue) {
    return;
  }

  emit('update:modelValue', page);
}
</script>

<template>
  <div class="bg-surface-inset inline-flex items-center gap-1 rounded-lg border p-1">
    <button
      type="button"
      :disabled="modelValue === 1"
      v-on:click="go(modelValue - 1)"
      class="text-foreground-muted enabled:hover:bg-accent/20 enabled:hover:text-accent flex size-7 items-center justify-center rounded-md text-xs transition-colors disabled:cursor-not-allowed disabled:opacity-40"
    >
      <font-awesome-icon icon="fa-solid fa-chevron-left" />
    </button>

    <template
      :key="`${page}-${index}`"
      v-for="(page, index) in pages"
    >
      <span
        v-if="page === '...'"
        class="text-foreground-muted flex size-7 items-center justify-center text-xs select-none"
      >
        …
      </span>

      <button
        v-else
        type="button"
        v-on:click="go(page)"
        :class="[
          'flex size-7 items-center justify-center rounded-md text-xs font-semibold transition-colors',
          page === modelValue
            ? 'bg-accent/20 text-accent'
            : 'text-foreground-muted hover:bg-accent/20 hover:text-accent',
        ]"
      >
        {{ page }}
      </button>
    </template>

    <button
      type="button"
      :disabled="modelValue === lastPage"
      v-on:click="go(modelValue + 1)"
      class="text-foreground-muted enabled:hover:bg-accent/20 enabled:hover:text-accent flex size-7 items-center justify-center rounded-md text-xs transition-colors disabled:cursor-not-allowed disabled:opacity-40"
    >
      <font-awesome-icon icon="fa-solid fa-chevron-right" />
    </button>
  </div>
</template>
