<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type Objeto, type BreadcrumbItem } from '@/types';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

import axios from 'axios';

const cargandoImagen = ref(true);
const cargando = ref(false);
const currentPage = ref(1);
const Objetos = ref<Objeto[]>([]);
const cantidades = ref<Record<number, number>>({});
const page = usePage();
const monedasUsuario = ref(page.props.auth.user.monedas);



window.addEventListener('actualizar-monedas', (event: Event) => {
    const customEvent = event as CustomEvent<number>;
    monedasUsuario.value = customEvent.detail;
});

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

function validarCantidad(id: number): void {
    const objeto = Objetos.value.find(o => o.id === id);
    if (!objeto) return;

    const cantidad = cantidades.value[id] ?? 1;
    const total = cantidad * objeto.precio;

    if (total > monedasUsuario.value) {
        // Ajustar la cantidad máxima permitida
        cantidades.value[id] = Math.floor(monedasUsuario.value / objeto.precio);
    } else if (cantidad < 1) {
        cantidades.value[id] = 1;
    }
}

const objetoActivo = ref<number | null>(null);

function toggleObjeto(id: number): void {
    objetoActivo.value = objetoActivo.value === id ? null : id;
}


async function comprarObjeto(id: number): Promise<void> {
    const cantidad = cantidades.value[id] ?? 1; // Valor por defecto: 1

    try {
        const response = await axios.patch(`/comprar/${id}`, { cantidad }, {
            withCredentials: true
        });
        alert(`¡Compra realizada!`);
        const data = response.data;
        window.dispatchEvent(new CustomEvent('actualizar-monedas', {
            detail: data.usuario.monedas
        }));
        const objeto = Objetos.value.find(o => o.id === id);
        if (objeto) {
            cantidades.value[id] = 1;
        }

    } catch (error) {
        console.error('Error al realizar la compra:', error);
        alert('Hubo un problema al realizar la compra.');
    }
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
            <div class="w-full ">

                <form>
                    <div class="grid grid-cols-4 gap-4 m-3">
                        <div v-for="objeto in Objetos" :key="objeto.id"
                            class="flex flex-col justify-between min-h-[150px]">
                            <div @click="toggleObjeto(objeto.id)"
                                class="p-4 bg-white rounded-lg shadow dark:bg-[#1b1b18] border-2 transition-all duration-200 cursor-pointer">
                                <h3 class="text-xl font-semibold text-center">{{ objeto.objeto }}</h3>
                                <div class="flex justify-center items-center h-32 p-0 m-0">
                                    <img v-if="cargandoImagen" src="/pokeball.png" alt="Cargando..."
                                        class="w-16 h-16 object-contain animate-pulse" />
                                    <img v-show="!cargandoImagen" :src="objeto.imagen" @load="cargandoImagen = false"
                                        alt="Berry" class="w-16 h-16 object-contain transition-opacity duration-300" />
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-center mt-2">{{ objeto.descripcion }}
                                </p>

                                <div class="flex justify-end items-center gap-x-2 mt-2">
                                    <template v-if="objetoActivo === objeto.id">
                                        <input type="number" v-model="cantidades[objeto.id]" min="1"
                                            :placeholder="`${Math.floor(monedasUsuario / objeto.precio)}`"
                                            class="w-15 p-1 border text-center rounded"
                                            @input="validarCantidad(objeto.id)" @click.stop /> x
                                    </template>

                                    <p class="text-gray-600 dark:text-gray-400 text-right">{{ objeto.precio }}$</p>

                                    <template v-if="objetoActivo === objeto.id">
                                        <p class="text-green-600 font-semibold">
                                            = {{ (cantidades[objeto.id] ?? 1) * objeto.precio }}$
                                        </p>
                                    </template>
                                </div>


                                <div v-if="objetoActivo === objeto.id" class="mt-2">
                                    <button type="button" @click="comprarObjeto(objeto.id)"
                                        :disabled="(cantidades[objeto.id] ?? 1) * objeto.precio > monedasUsuario"
                                        class="w-full px-4 py-2 rounded text-white" :class="{
                                            'bg-blue-500 hover:bg-blue-600': (cantidades[objeto.id] ?? 1) * objeto.precio <= monedasUsuario,
                                            'bg-gray-400 cursor-not-allowed': (cantidades[objeto.id] ?? 1) * objeto.precio > monedasUsuario
                                        }">
                                        Comprar
                                    </button>
                                </div>
                            </div>
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