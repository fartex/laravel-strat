<script setup lang="ts">
import { useI18n } from 'vue-i18n';

defineProps({
  modelValue: {
    required: true,
    type: [String, Number],
  },
});

const { t } = useI18n();

const tabs = [
  {
    count: 13,
    value: 'all',
    label: t('All'),
  },
  {
    count: 4,
    value: 'pending',
    label: t('Pending'),
  },
  {
    count: 9,
    value: 'executed',
    label: t('Executed'),
  },
];

const emit = defineEmits(['update:modelValue']);

function selectTab(value: string | number) {
  emit('update:modelValue', value);
}
</script>

<template>
  <div class="bg-surface-inset inline-flex items-center rounded-lg border p-1">
    <div
      :key="tab.value"
      v-for="tab in tabs"
      v-on:click="selectTab(tab.value)"
      :class="[
        'group flex cursor-pointer items-center gap-1.5 border-r px-3 py-1 text-sm font-semibold transition-colors select-none first:rounded-l-md last:rounded-r-md last:border-r-0',
        modelValue === tab.value ? 'bg-accent/20 text-accent' : 'text-foreground-muted',
      ]"
    >
      <span :class="modelValue !== tab.value && 'group-hover:text-foreground'">
        {{ tab.label }}
      </span>

      <span
        v-if="tab.count !== undefined"
        :class="[
          'text-sm font-light',
          modelValue === tab.value
            ? 'text-accent'
            : 'text-foreground-muted group-hover:text-foreground',
        ]"
      >
        {{ tab.count }}
      </span>
    </div>
  </div>
</template>
