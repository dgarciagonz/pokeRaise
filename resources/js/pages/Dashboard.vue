<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { type Pokemon, type Diaria } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';
import axios from 'axios';


const sprite = ref('');
const nombre = ref('');
let tipo = ref<string[]>([]);
const apodo = ref('');
const felicidad = ref(0);
const nivel = ref(0);
const experiencia = ref(0);
const hambre = ref(0);
const cargandoImagen = ref(true);


const diarias = ref<Diaria[]>([]);
const tareasCompletadas = ref<number[]>([]);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

async function cargarDiarias(): Promise<Diaria[] | undefined> {
    try {
        const response = await axios.get('/diarias', { withCredentials: true });
        return response.data.data as Diaria[] | undefined;
    } catch (error) {
        console.error('Error al cargar las diarias:', error);
    }

}


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

//Funcion para completar las tareas diarias
async function completarDiaria(idDiaria: number): Promise<void> {
    try {
        const response = await axios.patch(`/diaria/${idDiaria}`, {}, {
            withCredentials: true
        });

        //Datos actualizados
        const data = response.data;

        experiencia.value = data.pokemon.experiencia;
        felicidad.value = data.pokemon.felicidad;
        hambre.value = data.pokemon.hambre;
        nivel.value = data.pokemon.nivel;

        const infoPokemon = await pokeApi(data.pokemon.pokeapi_url);

        if (!infoPokemon || !infoPokemon.sprites) return;

        sprite.value = data.pokemon.variocolor
            ? infoPokemon.sprites.other.showdown.front_shiny
            : infoPokemon.sprites.other.showdown.front_default;

        nombre.value = infoPokemon.name;

        tipo.value = [];
        for (const t of infoPokemon.types) {
            const tipoInfo = await pokeApi(t.type.url);
            if (tipoInfo) {
                tipo.value.push(tipoInfo['sprites']['generation-viii']['sword-shield']['name_icon']);
            }
        }
        //Dinero del usuario:
        window.dispatchEvent(new CustomEvent('actualizar-monedas', {
            detail: data.usuario.monedas
        }));

        tareasCompletadas.value.push(idDiaria);

    } catch (error) {
        console.error('Error al completar diaria:', error);
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

    for (const t of infoPokemon.types) {
        const tipoInfo = await pokeApi(t.type.url);
        if (tipoInfo) {
            tipo.value.push(tipoInfo['sprites']['generation-viii']['sword-shield']['name_icon']);
        }
    }
    apodo.value = pokemonActivo.apodo;
    felicidad.value = pokemonActivo.felicidad;
    nivel.value = pokemonActivo.nivel;
    experiencia.value = pokemonActivo.experiencia;
    hambre.value = pokemonActivo.hambre;

    const diariasData = await cargarDiarias();
    if (!diariasData) {
        console.warn('No se pudieron cargar las diarias');
        return;
    }

    diarias.value = diariasData;
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
                <div class="mt-6 flex justify-center align-items-baseline">
                    <!-- Imagen de carga (pokeball) -->
                    <img v-if="cargandoImagen" src="/pokeball.png" alt="Cargando..."
                        class=" w-32 h-32 object-contain animate-pulse" />

                    <!-- Imagen del Pokémon -->
                    <img v-show="!cargandoImagen" :src="sprite" @load="cargandoImagen = false" alt="Pokémon"
                        class="w-32 h-32 object-contain transition-opacity duration-300" />
                </div>
                <div class="" v-show="!cargandoImagen">
                    <h1 class="text-2xl font-bold capitalize">{{ nombre }}</h1>
                    <p><strong>Apodo:</strong> {{ apodo }}</p>

                    <div class="flex justify-around justify-start ">
                        <div v-for="(sprite, index) in tipo" :key="index" class="d-flex ">
                            <img v-show="!cargandoImagen" :src="sprite" @load="cargandoImagen = false"
                                alt="tipo pokemon" class="w-25  object-contain " />
                        </div>
                    </div>

                    <p><strong>Nivel</strong> {{ nivel }}</p>
                    <div class="flex space-x-1 mt-1">
                        <span v-for="n in 5" :key="n">
                            {{ n <= Math.floor(felicidad / 20) ? '❤️' : '🖤' }} </span>
                    </div>
                    <p><strong>Experiencia:</strong></p>
                    <div
                        style="width: 100%; background-color: #e5e7eb; border-radius: 8px; overflow: hidden; height: 20px;">
                        <div :style="{ width: experiencia + '%', backgroundColor: '#3b82f6', height: '100%' }"></div>
                    </div>

                    <!-- Hambre -->
                    <p><strong>Hambre:</strong></p>
                    <div
                        style="width: 100%; background-color: #e5e7eb; border-radius: 8px; overflow: hidden; height: 20px;">
                        <div :style="{ width: hambre + '%', backgroundColor: '#facc15', height: '100%' }"></div>
                    </div>
                </div>

            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">

                <div class="w-full ">
                    <div class="grid grid-cols-3 gap-4 m-3">

                        <div v-for="d in diarias" :key="d.id" class="flex flex-col justify-between min-h-[150px]">

                            <label :class="[
                                'flex flex-col justify-between p-4 rounded-lg shadow border-2 transition h-full',
                                tareasCompletadas.includes(d.id) || d.completado
                                    ? 'bg-green-200 dark:bg-green-800 border-green-400'
                                    : 'bg-white dark:bg-[#1b1b18] border-gray-200 dark:border-sidebar-border'
                            ]">

                                <h3 class="text-lg font-semibold text-center">{{ d.tarea.titulo }}</h3>
                                <p class="text-sm font-semibold text-green-600 dark:text-green-400 text-center">{{ d.tarea.categoria.nombre }}</p>
                                <div class="flex items-center justify-center space-x-4 px-4">
                                    <p>+{{ d.tarea.experiencia }} XP</p>
                                    <p>+{{ d.tarea.recompensa }}$</p>
                                </div>

                                <div class="mt-6 flex justify-center align-items-baseline"
                                    v-if="!tareasCompletadas.includes(d.id) || !d.completado">
                                    <button @click="completarDiaria(d.id)"
                                        :disabled="tareasCompletadas.includes(d.id) || d.completado"
                                        class="mt-2 px-3 py-1 rounded transition text-white bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Completar
                                    </button>
                                </div>

                            </label>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
