// ** Local Imports
import { IMenuItems } from '@shared/App/menu';

// prettier-ignore
export const admin = (): IMenuItems => {
    return [
        {
            id: "9hfm5",
            title: "Dashboard",
            path: "/dashboard",
            icon: "fas fa-table",
        },
        {
            id: "8fa7s",
            title: "Settings",
            path: "/settings",
            icon: "fas fa-gear",
        }
    ];
}
