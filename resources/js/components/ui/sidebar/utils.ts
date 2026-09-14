import { createContext } from 'reka-ui';
import type { ComputedRef, CSSProperties, Ref } from 'vue';

export const SIDEBAR_COOKIE_NAME = 'sidebar_state';
export const SIDEBAR_COOKIE_MAX_AGE = 60 * 60 * 24 * 7;
export const SIDEBAR_WIDTH = '16rem';
export const SIDEBAR_WIDTH_MOBILE = '18rem';
export const SIDEBAR_WIDTH_ICON = '3rem';
export const SIDEBAR_KEYBOARD_SHORTCUT = 'b';

export type SidebarState = 'expanded' | 'collapsed';

export interface SidebarContext {
    state: ComputedRef<SidebarState>;
    open: Ref<boolean>;
    setOpen: (open: boolean) => void;
    isMobile: Ref<boolean>;
    openMobile: Ref<boolean>;
    setOpenMobile: (open: boolean) => void;
    toggleSidebar: () => void;
}

export const [useSidebar, provideSidebarContext] =
    createContext<SidebarContext>('Sidebar');
