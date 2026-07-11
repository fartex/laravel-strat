<script setup lang="ts">
// ** Local Imports
import type { TColor } from '@shared/App/types/shared';

defineProps({
  icon: {
    type: String,
    default: null,
  },
  text: {
    type: String,
    required: true,
  },
  variant: {
    default: 'flat',
    type: String as () => keyof typeof variantClasses,
  },
  color: {
    default: 'info',
    type: String as () => TColor,
  },
});

const variantClasses: Record<'flat' | 'outline', Record<TColor, string>> = {
  flat: {
    info: 'bg-info text-primary',
    danger: 'bg-danger text-primary',
    accent: 'bg-accent text-primary',
    success: 'bg-success text-primary',
    warning: 'bg-warning text-primary',
  },
  outline: {
    info: 'border border-info text-info',
    danger: 'border border-danger text-danger',
    accent: 'border border-accent text-accent',
    success: 'border border-success text-success',
    warning: 'border border-warning text-warning',
  },
};
</script>

<template>
  <button
    type="button"
    :class="[
      variantClasses[variant][color],
      'inline-flex cursor-pointer items-center gap-1 rounded-md px-3 py-1.5 text-sm font-medium transition-opacity hover:opacity-90',
    ]"
  >
    <font-awesome-icon
      v-if="icon"
      :icon="icon"
    />

    {{ text }}
  </button>
</template>
