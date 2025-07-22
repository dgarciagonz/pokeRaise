<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { type Categoria } from '@/types';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import axios from 'axios';


const preferencias = ref<Categoria[]>([]);
const categoriasSeleccionadas = ref<number[]>([]);

function getCookie(name: string): string | null {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop()!.split(';').shift()!;
    return null;
}

async function cargarCategorias(): Promise<Categoria[] | undefined> {
    try {

        const response = await fetch('/api/categorias', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            const error = await response.json();
            alert(`Error: ${error.detail || 'Error al cargar categorías'}`);
            return;
        }

        const data = await response.json();
        return data.data as Categoria[];
    } catch (error) {
        console.error('Error al cargar las categorías:', error);
        return;
    }

}

async function enviarPreferencias() {
     try {
        await axios.get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true });
        await axios.post('/preferencias', {
            categorias: categoriasSeleccionadas.value
        }, {
            withCredentials: true
        });
        alert('Preferencias guardadas correctamente');
        router.visit('/dashboard');
    } catch (error) {
        alert('Error al guardar preferencias');
        console.error(error);
    }
}


async function cargarDatos(): Promise<void> {
    const categorias = await cargarCategorias();
    if (!categorias) {
        console.warn('Error al cargar las categorias');
        return;
    }

    preferencias.value = categorias.map(categoria => ({
        id: categoria.id,
        nombre: categoria.nombre,
        descripcion: categoria.descripcion,
    }));


}

onMounted(async () => {
    await fetch('http://localhost:8000/sanctum/csrf-cookie', { credentials: 'include' });
    cargarDatos();
});

</script>

<template>

    <Head title="Preferencias">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <h1 class="text-2xl font-bold mb-6">Preferencias</h1>
        <div class="w-full max-w-2xl">

            <form @submit.prevent="enviarPreferencias">
                <div class="grid grid-cols-3 gap-4">
                    <div v-for="categoria in preferencias" :key="categoria.id" class="grid grid-cols-1">
                        <label
                            class="p-4 bg-white rounded-lg shadow dark:bg-[#1b1b18] border-2 transition-all duration-200 cursor-pointer"
                            :class="{
                                'border-green-500': categoriasSeleccionadas.includes(categoria.id),
                                'border-transparent': !categoriasSeleccionadas.includes(categoria.id)
                            }">
                            <h2 class="text-xl font-semibold">{{ categoria.nombre }}</h2>
                            <p class="text-gray-600 dark:text-gray-400">{{ categoria.descripcion }}</p>
                            <input type="checkbox" :value="categoria.id" v-model="categoriasSeleccionadas"
                                class="hidden" />
                        </label>
                    </div>
                </div>
                <div class="mt-6 flex justify-center">
                    <button type="submit" class="mt-4 px-4 py-2 hover text-white rounded" :class="{
                        'bg-green-600 hover:bg-green-700': categoriasSeleccionadas.length > 0,
                        'bg-gray-400 cursor-not-allowed': categoriasSeleccionadas.length < 1
                    }">
                        Guardar preferencias
                    </button>
                </div>
            </form>


        </div>
    </div>
</template>