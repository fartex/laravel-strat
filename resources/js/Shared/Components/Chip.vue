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
  color: {
    default: null,
    type: String as () => TColor | null,
  },
  rounded: {
    default: 'md',
    type: String as () => 'xs' | 'sm' | 'md' | 'lg' | 'full',
  },
  font: {
    default: 'normal',
    type: String as () => 'bold' | 'light' | 'medium' | 'normal' | 'semibold',
  },
});

const colorClasses: Record<TColor, string> = {
  info: 'text-info border-info bg-info/15',
  danger: 'text-danger border-danger bg-danger/15',
  accent: 'text-accent border-accent bg-accent/15',
  success: 'text-success border-success bg-success/15',
  warning: 'text-warning border-warning bg-warning/15',
};
</script>

<template>
  <div
    :class="[
      color ? colorClasses[color] : 'text-foreground-muted',
      'flex items-center gap-1 border px-2 text-xs',
      {
        'font-bold': font === 'bold',
        'rounded-xs': rounded === 'xs',
        'rounded-sm': rounded === 'sm',
        'rounded-md': rounded === 'md',
        'rounded-lg': rounded === 'lg',
        'font-light': font === 'light',
        'font-medium': font === 'medium',
        'font-normal': font === 'normal',
        'rounded-full': rounded === 'full',
        'font-semibold': font === 'semibold',
      },
    ]"
  >
    <font-awesome-icon
      v-if="icon"
      :icon="icon"
    />
    {{ text }}
  </div>
</template>
