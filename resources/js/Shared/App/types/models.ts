import { MigrationStatusEnum, MigrationTypeEnum } from '@shared/App/enum';

export interface Migration {
    id: number;
    migration: string;
    table: string;
    connection: string;
    type: MigrationTypeEnum;
    status: MigrationStatusEnum;
    batch: number | null;
    executed_at: string | null;
    duration_ms: number | null;
    created_at: string;
    updated_at: string;
}
