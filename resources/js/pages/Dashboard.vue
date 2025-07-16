<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { type Pokemon } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const sprite = ref('');
const nombre = ref('');
const tipo = ref('');
const apodo = ref('');
const felicidad = ref(0);
const nivel = ref(0);
const experiencia = ref(0);
const hambre = ref(0);
const cargandoImagen = ref(true);


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

async function cargarPokemonActivo(): Promise<Pokemon | undefined> {
    try {
        const response = await fetch('/pokemons/activos', {
            method: 'GET',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            const error = await response.json();
            alert(`Error: ${error.detail || 'Error al cargar pokemon activo'}`);
            return;
        }

        const data = await response.json();
        return data.data as Pokemon;
    } catch (error) {
        console.error('Error al cargar el Pokémon activo:', error);
    }
}

// Llamar a la PokéAPI con la URL que te dio el backend
async function pokeApi(url: string): Promise<any> {
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            const error = await response.json();
            alert(`Error: ${error.detail || 'Error al cargar datos de PokéAPI'}`);
            return;
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al cargar datos de la PokéAPI:', error);
    }
}

// Función principal que orquesta ambas llamadas
async function cargarApi(): Promise<void> {
    const pokemonActivo = await cargarPokemonActivo();
    if (!pokemonActivo || !pokemonActivo.pokeapi_url) {
        console.warn('hola');
        return;
    }

    const infoPokemon = await pokeApi(pokemonActivo.pokeapi_url);

    if (!infoPokemon || !infoPokemon.sprites) return;

    sprite.value = pokemonActivo.variocolor
        ? infoPokemon.sprites.other.showdown.front_shiny
        : infoPokemon.sprites.other.showdown.front_default;

    nombre.value = infoPokemon.name;
    tipo.value = infoPokemon.types.map((type: any) => type.type.name).join(', ');

    apodo.value = pokemonActivo.apodo;
    felicidad.value = pokemonActivo.felicidad;
    nivel.value = pokemonActivo.nivel;
    experiencia.value = pokemonActivo.experiencia;
    hambre.value = pokemonActivo.hambre;
}

onMounted(() => {
    cargarApi();
});

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="md:col-span-1">
                    <!-- Imagen de carga (pokeball) -->
                    <img v-if="cargandoImagen" src="/pokeball.png" alt="Cargando..."
                        class=" w-32 h-32 object-contain animate-pulse" />

                    <!-- Imagen del Pokémon -->
                    <img v-show="!cargandoImagen" :src="sprite" @load="cargandoImagen = false" alt="Pokémon"
                        class="w-32 h-32 object-contain transition-opacity duration-300" />
                </div>
                <div class="md:col-span-2" v-show="!cargandoImagen">
                    <h1 class="text-2xl font-bold capitalize">{{ nombre }}</h1>
                    <p><strong>Apodo:</strong> {{ apodo }}</p>
                    <p><strong>Tipo:</strong> {{ tipo }}</p>
                    <p><strong>Nivel</strong> {{ nivel }}</p>
                    <p><strong>Felicidad:</strong> {{ felicidad }}%</p>
                    <p><strong>Experiencia:</strong> {{ experiencia }}</p>
                    <p><strong>Hambre:</strong> {{ hambre }}%</p>
                </div>

            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
                Tareas
            </div>
        </div>
    </AppLayout>
</template>
