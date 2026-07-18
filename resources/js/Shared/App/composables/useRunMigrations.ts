// ** External Imports
import { ref } from 'vue';
import axios from 'axios';

// Run a single migration, or every pending migration when no id is given
export function useRunMigrations() {
    const runningIds = ref<Set<number>>(new Set());
    const runningAll = ref(false);

    const runMigrations = (id: number | null = null) => {
        if (id === null) {
            runningAll.value = true;
        } else {
            runningIds.value.add(id);
        }

        return axios.get(id === null ? '/run-migrations' : `/run-migrations/${id}`).finally(() => {
            if (id === null) {
                runningAll.value = false;
            } else {
                runningIds.value.delete(id);
            }
        });
    };

    return { runningIds, runningAll, runMigrations };
}
