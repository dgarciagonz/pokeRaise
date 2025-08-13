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
    email_verified_at: string | null;
    created_at: string;
    monedas:number;
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
export interface Preferencia {
    id: number;
    user: number;
    categoria: number;
}

export interface Objeto{
    id:number;
    objeto: string;
    categoria: string;
    precio:number;
    descipcion:string;
    imagen:string;
}

export interface Tarea{
    id:number;
    id_categoria: number;
    titulo: string;
    experiencia:number;
    recompensa:number;
    categoria: Categoria;
}

export interface Diaria {
  id: number;
  id_usuario: number;
  id_tarea: number;
  fecha: string;
  completado: boolean;
  tarea: Tarea;
}



export type BreadcrumbItemType = BreadcrumbItem;
