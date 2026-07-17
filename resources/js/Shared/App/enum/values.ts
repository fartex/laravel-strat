import { DatabaseDriverEnum, LocaleEnum } from '@shared/App/enum';

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
