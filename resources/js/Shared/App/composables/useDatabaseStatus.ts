// ** External Imports
import { onMounted, onUnmounted, ref } from 'vue';
import axios from 'axios';

// ** Local Imports
import { TDatabaseConnectionStatus } from '@shared/App/types/shared';

// Get all database connections status
export function useDatabaseStatus() {
    const connections = ref<TDatabaseConnectionStatus[]>([]);
    let timer: ReturnType<typeof setInterval> | undefined;

    const getStatus = (): void => {
        axios
            .get<TDatabaseConnectionStatus[]>('/database-status')
            .then((response) => {
                connections.value = response.data;
            })
            .catch(() => {
                connections.value = connections.value.map((connection) => ({
                    ...connection,
                    online: false,
                }));
            });
    };

    onMounted(() => {
        getStatus();

        timer = setInterval(getStatus, 15000);
    });

    onUnmounted(() => {
        clearInterval(timer);
    });

    return { connections };
}
