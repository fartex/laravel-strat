// ** Local Imports
import { admin } from '@shared/App/menu/admin';
import type { TColor } from '@shared/App/types/shared';

export type IMenu = IMenuLink | IMenuGroup | IMenuSection;

export type IMenuGroup = {
    id: string;
    icon?: string;
    title: string;
    options: IMenuItems;
    prepend?: IPrepend;
};

export type IMenuItems = IMenu[];

export type IMenuLink = {
    id: string;
    path: string;
    icon?: string;
    title: string;
    prepend?: IPrepend;
};

export type IMenuSection = {
    id: string;
    section: string;
};

export type IPrepend = {
    text: string;
    color: TColor;
};

export function menu(item: string): IMenuItems {
    switch (item) {
        case 'admin':
            return admin();
        default:
            return [];
    }
}
