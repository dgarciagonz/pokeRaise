<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type Objeto,type BreadcrumbItem } from '@/types';
import { onMounted } from 'vue';
import { ref } from 'vue';

import axios from 'axios';

const cargandoImagen = ref(true);
const cargando = ref(false);
const currentPage = ref(1);
const Objetos = ref<Objeto[]>([]);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tienda',
        href: '/tienda',
    },
];

async function cargarObjetosTienda(pagina = 1): Promise<Objeto[]> {
    try {
        cargando.value = true;
        const response = await axios.get(`/api/stock?page=${pagina}`);
        return response.data.data as Objeto[] ?? [];
    } catch (error) {
        console.error('Error al cargar el stock:', error);
        return [];
    } finally {
        cargando.value = false;
    }
}

const sentinel = ref<HTMLElement | null>(null);

async function cargarDatos(): Promise<void> {
    Objetos.value = await cargarObjetosTienda();
}

async function cargarMasDatos(): Promise<void> {
    currentPage.value++;
    const nuevos = await cargarObjetosTienda(currentPage.value);
    Objetos.value.push(...nuevos);

}

onMounted(async () => {
    await fetch('http://localhost:8000/sanctum/csrf-cookie', { credentials: 'include' });
    cargarDatos();
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && !cargando.value) {
            cargarMasDatos();
        }
    });

    if (sentinel.value) {
        observer.observe(sentinel.value);
    }

});

</script>

<template>

    <Head title="Tienda">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
            <h1 class="text-2xl font-bold mb-6">Bayas</h1>
            <div class="w-full max-w-2xl">

                <form>
                    <div class="grid grid-cols-5 gap-4">
                        <div v-for="objeto in Objetos" :key="objeto.id" class="grid grid-cols-1">
                            <label
                                class="p-4 bg-white rounded-lg shadow dark:bg-[#1b1b18] border-2 transition-all duration-200 cursor-pointer">
                                <h3 class="text-xl font-semibold text-center">{{ objeto.objeto }}</h3>

                                <div class="flex justify-center items-center h-32 p-0 m-0">
                                    <img v-if="cargandoImagen" src="/pokeball.png" alt="Cargando..."
                                        class="w-16 h-16 object-contain animate-pulse" />
                                    <img v-show="!cargandoImagen" :src="objeto.imagen" @load="cargandoImagen = false"
                                        alt="Berry" class="w-16 h-16 object-contain transition-opacity duration-300" />
                                </div>

                                <p class="text-gray-600 dark:text-gray-400 text-left"> Recupera {{ objeto.precio*2 }} de hambre</p>
                                <p class="text-gray-600 dark:text-gray-400 text-right">{{ objeto.precio }}$</p>
                            </label>
                        </div>
                    </div>
                    <div ref="sentinel" class="h-10"></div>
                    <div class="mt-6 flex justify-center">

                    </div>
                </form>


            </div>
        </div>
    </AppLayout>
</template>