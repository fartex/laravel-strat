<script setup lang="ts">
// ** External Imports
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
  modelValue: {
    required: true,
    type: String,
  },
  databases: {
    required: true,
    type: Array as () => string[],
  },
});

const { t } = useI18n();

const emit = defineEmits(['update:modelValue']);

const tabs = computed(() => [
  {
    value: 'all',
    label: t('All'),
  },
  ...props.databases.map((database) => ({
    value: database,
    label: database,
  })),
]);

function selectTab(value: string) {
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
        'group flex cursor-pointer items-center gap-1.5 border-r px-3 py-1 text-sm ' +
          'font-semibold transition-colors select-none first:rounded-l-md last:rounded-r-md last:border-r-0',
        modelValue === tab.value ? 'bg-accent/20 text-accent' : 'text-foreground-muted',
      ]"
    >
      <span :class="modelValue !== tab.value && 'group-hover:text-foreground'">
        {{ tab.label.substring(0, 15) }}
      </span>
    </div>
  </div>
</template>
