import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

declare module '@tailwindcss/vite' {
    import { Plugin } from 'vite'
    export default function tailwindcss(): Plugin
}

declare module '@vitejs/plugin-vue' {
    import { Plugin } from 'vite'
    export interface Options {
        template?: {
            transformAssetUrls?: Record<string, any>
        }
    }
    export default function vue(options?: Options): Plugin
}

// Inventory Items
export interface InventoryItem {
    id: number;
    name: string;
    quantity: number;
    sku: string;
    notification_sent: boolean;
}

export interface InventoryItemForm {
    name: string;
    quantity: number;
    sku: string;
    notification_sent: boolean;
}
