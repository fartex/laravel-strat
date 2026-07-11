// ** External Imports
import { reactive } from 'vue';

const openGroups = reactive(new Set<string>());

export function useMenuGroups() {
    const isOpen = (id: string): boolean => openGroups.has(id);

    const toggleGroup = (id: string): void => {
        if (openGroups.has(id)) {
            openGroups.delete(id);
        } else {
            openGroups.add(id);
        }
    };

    return { isOpen, toggleGroup };
}
