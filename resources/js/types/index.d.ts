import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    username: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Pokemon {
    id: number;
    id_entrenador:number;
    nombre: string;
    pokeapi_url: string;
    nivel:number;
    experiencia:number;
    hambre:number;
    felicidad:number;
    variocolor:boolean;
    activo:boolean;
    apodo:string;
    lineaEvolutiva:string;
    entrenador_original:number;
}

export interface Categoria {
    id: number;
    nombre: string;
    descripcion: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
