<script setup lang="ts">
// ** External Imports
import { useI18n } from 'vue-i18n';

// ** Local Imports
import type { TMigrationCounts } from '@shared/App/types/shared';

defineProps({
  counts: {
    required: true,
    type: Object as () => TMigrationCounts,
  },
});
</script>

<template>
  <div class="flex flex-row gap-1 py-1 text-xs">
    <span>
      {{ $t('migrations.total', { count: counts.total }) }}
    </span>
    ·
    <span class="text-success">
      {{ $t('migrations.executed', { count: counts.executed }) }}
    </span>
    ·
    <span class="text-accent">
      {{ $t('migrations.pending', { count: counts.pending }) }}
    </span>
  </div>
</template>
