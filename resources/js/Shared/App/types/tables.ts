export interface TTableColumn {
    key: string;
    title: string;
}

export const MigrationTable: TTableColumn[] = [
    {
        key: 'status',
        title: 'Status',
    },
    {
        key: 'migration',
        title: 'Migration',
    },
    {
        key: 'type',
        title: 'Type',
    },
    {
        key: 'table',
        title: 'Table',
    },
    {
        key: 'connection',
        title: 'Database',
    },
    {
        key: 'batch',
        title: 'Batch',
    },
    {
        key: 'executed',
        title: 'Executed',
    },
    {
        key: 'duration',
        title: 'Duration',
    },
    {
        key: 'actions',
        title: '',
    },
];
