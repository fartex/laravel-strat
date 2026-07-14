import { DatabaseDriverEnum, LocaleEnum } from '@shared/App/enum';

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

export const DatabaseDriverValues: Record<DatabaseDriverEnum, string> = {
    [DatabaseDriverEnum.MYSQL]: 'MySQL',
    [DatabaseDriverEnum.PGSQL]: 'PostgreSQL',
    [DatabaseDriverEnum.SQLITE]: 'SQLite',
    [DatabaseDriverEnum.SQLSRV]: 'SQL Server',
};
