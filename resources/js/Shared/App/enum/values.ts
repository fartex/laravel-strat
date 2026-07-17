import {
    DatabaseDriverEnum,
    LocaleEnum,
    MigrationStatusEnum,
    MigrationTypeEnum,
} from '@shared/App/enum';
import type { TColor } from '@shared/App/types/shared';

export const DatabaseDriverValues: {
    title: string;
    value: string;
}[] = [
    {
        value: DatabaseDriverEnum.MYSQL,
        title: `enum.database_driver.${DatabaseDriverEnum.MYSQL}`,
    },
    {
        value: DatabaseDriverEnum.SQLITE,
        title: `enum.database_driver.${DatabaseDriverEnum.SQLITE}`,
    },
    {
        value: DatabaseDriverEnum.PGSQL,
        title: `enum.database_driver.${DatabaseDriverEnum.PGSQL}`,
    },
    {
        value: DatabaseDriverEnum.SQLSRV,
        title: `enum.database_driver.${DatabaseDriverEnum.SQLSRV}`,
    },
];

export const LocaleValues: {
    title: string;
    value: string;
}[] = [
    {
        value: LocaleEnum.PT_BR,
        title: `enum.locale.${LocaleEnum.PT_BR}`,
    },
    {
        value: LocaleEnum.EN_US,
        title: `enum.locale.${LocaleEnum.EN_US}`,
    },
];

export const MigrationStatusValues: {
    title: string;
    value: string;
    color: TColor;
}[] = [
    {
        value: MigrationStatusEnum.PENDING,
        title: `enum.migration_status.${MigrationStatusEnum.PENDING}`,
        color: 'warning',
    },
    {
        value: MigrationStatusEnum.EXECUTED,
        title: `enum.migration_status.${MigrationStatusEnum.EXECUTED}`,
        color: 'success',
    },
];

export const MigrationTypeValues: {
    title: string;
    value: string;
    color: TColor;
}[] = [
    {
        color: 'success',
        value: MigrationTypeEnum.CREATE,
        title: `enum.migration_type.${MigrationTypeEnum.CREATE}`,
    },
    {
        color: 'accent',
        value: MigrationTypeEnum.ALTER,
        title: `enum.migration_type.${MigrationTypeEnum.ALTER}`,
    },
    {
        color: 'danger',
        value: MigrationTypeEnum.DROP,
        title: `enum.migration_type.${MigrationTypeEnum.DROP}`,
    },
    {
        color: 'warning',
        value: MigrationTypeEnum.RENAME,
        title: `enum.migration_type.${MigrationTypeEnum.RENAME}`,
    },
    {
        color: 'info',
        value: MigrationTypeEnum.UNKNOWN,
        title: `enum.migration_type.${MigrationTypeEnum.UNKNOWN}`,
    },
];
