export type TColor = 'info' | 'danger' | 'accent' | 'success' | 'warning';

export interface TDatabaseConnectionStatus {
    name: string;
    online: boolean;
    driver: string | null;
    database: string | null;
    latency_ms: number | null;
}

export type TTabs = [value: string, label: string, count: number | null];

export interface TMigrationCounts {
    total: number;
    executed: number;
    pending: number;
}

export interface TPaginated<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}
