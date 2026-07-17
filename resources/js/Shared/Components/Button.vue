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
    default: null,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  spin: {
    type: Boolean,
    default: false,
  },
  color: {
    default: 'info',
    type: String as () => TColor,
  },
  variant: {
    default: 'flat',
    type: String as () => keyof typeof variantClasses,
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
    :disabled="disabled"
    :class="[
      variantClasses[variant][color],
      'inline-flex items-center gap-1 rounded-md px-3 py-1.5 text-sm font-medium transition-opacity hover:opacity-90',
      disabled ? 'cursor-not-allowed opacity-50 hover:opacity-50' : 'cursor-pointer',
    ]"
  >
    <font-awesome-icon
      v-if="icon"
      :icon="icon"
      :spin="spin"
    />

    {{ text }}
  </button>
</template>
