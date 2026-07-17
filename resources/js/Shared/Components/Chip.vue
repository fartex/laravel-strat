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
  variant: {
    default: 'flat',
    type: String as () => 'flat' | 'outline',
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

const borderClasses: Record<TColor, string> = {
  info: 'border-info',
  danger: 'border-danger',
  accent: 'border-accent',
  success: 'border-success',
  warning: 'border-warning',
};

const colorClasses: Record<TColor, string> = {
  info: 'text-info bg-info/15',
  danger: 'text-danger bg-danger/15',
  accent: 'text-accent bg-accent/15',
  success: 'text-success bg-success/15',
  warning: 'text-warning bg-warning/15',
};
</script>

<template>
  <div
    :class="[
      {
        'font-bold': font === 'bold',
        border: variant === 'outline',
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
      'flex items-center gap-1 px-2 text-[10px]',
      color ? colorClasses[color] : 'text-foreground-muted',
      variant === 'outline' && color ? borderClasses[color] : '',
    ]"
  >
    <font-awesome-icon
      v-if="icon"
      :icon="icon"
    />
    {{ text }}
  </div>
</template>
