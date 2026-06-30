import type { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from '@lucide/vue';

export type BreadcrumbItem = {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
};

export type NavItem = {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    iconClass?: string;
    isActive?: boolean;
    items?: {
        title: string;
        href: NonNullable<InertiaLinkProps['href']>;
        isActive?: boolean;
    }[];
};
