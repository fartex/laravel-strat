// ** External Imports
import { ref } from 'vue';
import axios from 'axios';

// Shared across every caller (navbar + table rows) so a run triggered from
// one place is reflected everywhere, including the "ran" timestamp below.
const runningIds = ref<Set<number>>(new Set());
const runningAll = ref(false);
const lastRanAt = ref(0);

// Run a single migration, or every pending migration when no id is given
export function useRunMigrations() {
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

            lastRanAt.value = Date.now();
        });
    };

    return { runningIds, runningAll, lastRanAt, runMigrations };
}
