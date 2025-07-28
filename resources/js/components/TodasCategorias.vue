<script setup lang="ts">
import { type Categoria } from '@/types';

export async function cargarCategorias(): Promise<Categoria[] | undefined> {
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
</script>


