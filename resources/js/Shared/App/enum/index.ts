export enum DatabaseDriverEnum {
    MYSQL = 'mysql',
    PGSQL = 'pgsql',
    SQLITE = 'sqlite',
    SQLSRV = 'sqlsrv',
}

export enum LocaleEnum {
    PT_BR = 'pt-BR',
    EN_US = 'en-US',
}

export enum MigrationStatusEnum {
    PENDING = 'pending',
    EXECUTED = 'executed',
}

export enum MigrationTypeEnum {
    CREATE = 'create',
    ALTER = 'alter',
    DROP = 'drop',
    RENAME = 'rename',
    UNKNOWN = 'unknown',
}
