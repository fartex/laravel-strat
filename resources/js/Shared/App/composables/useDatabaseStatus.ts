// ** External Imports
import { onMounted, onUnmounted, ref } from 'vue';
import axios from 'axios';

export interface DatabaseConnectionStatus {
    name: string;
    online: boolean;
    driver: string | null;
    database: string | null;
    latency_ms: number | null;
}

export function useDatabaseStatus() {
    const connections = ref<DatabaseConnectionStatus[]>([]);
    let timer: ReturnType<typeof setInterval> | undefined;

    const fetchStatus = (): void => {
        axios
            .get<DatabaseConnectionStatus[]>('/database-status')
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
        fetchStatus();

        timer = setInterval(fetchStatus, 15000);
    });

    onUnmounted(() => {
        clearInterval(timer);
    });

    return { connections };
}
