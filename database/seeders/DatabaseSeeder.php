<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    

    public function Categorias()
    {
        $categoriasNombre = ["Salud", "Estudios", "Deporte", "Creatividad", "Gestión", "Programación", "Idiomas", "Relajación", "Social", "Belleza"];
        $categoriasDescripcion = [
            "Bienestar físico y mental",
            "Aprendizaje y formación",
            "Actividad física",
            "Expresión creativa",
            "Organización y productividad",
            "Desarrollo tecnológico",
            "Habilidades comunicativas y nuevas lenguas",
            "Fomentar el equilibrio y la calma",
            "Fortalecer los vínculos personales",
            "Cuidado personal y bienestar físico"
        ];


        for ($i=0; $i < count($categoriasNombre); $i++) { 
                    $nCategoria= new Categoria;
                    $nCategoria->nombre_categoria = $categoriasNombre[$i];
                    $nCategoria->descripcion = $categoriasDescripcion[$i];
                    $nCategoria->save();
        }
 
    }

    public function Tareas(){
        $tareaSalud = [
             "Beber 2 litros de agua",
             "Dormir 7–8 horas",
             "Comer 5 frutas o verduras",
             "Evitar azúcar procesada",
             "Tomar el sol 15 minutos",
             "Revisar postura corporal",
             "Hacer estiramientos",
             "Tomar suplementos si es necesario",
             "Revisar presión o pulso",
             "Tiempo de uso de pantallas menor de 4h",
             "Caminar 30 minutos",
             "Comrpobar nivel de estrés",
             "Practicar respiración consciente",
             "Comprobar dolencias físicas",
             "Escribir cómo te sientes hoy"
        ];

        $tareaEstudio = [
            "Leer 10 páginas del libro",
             "Ver un video explicativo",
             "Tomar notas de lo aprendido",
             "Resumir lo estudiado",
             "Repasar conceptos anteriores",
             "Realizar un simulacro de examen",
             "Estudiar un tema nuevo",
             "Explicar lo aprendido a alguien",
             "Hacer un mapa mental",
             "Buscar artículos sobre un tema",
             "Resolver ejercicios prácticos",
             "Revisar errores pasados",
             "Organizar apuntes",
             "Programar bloques de estudio",
             "Escuchar podcast educativo"
        ];

        $tareaDeporte = [
             "Hacer 30 minutos de cardio",
             "Entrenamiento de fuerza",
             "Practicar yoga o pilates",
             "Subir escaleras",
             "Caminar 10.000 pasos",
             "Jugar un deporte grupal",
             "Saltar la cuerda",
             "Hacer sentadillas o flexiones",
             "Probar una rutina nueva",
             "Estirar",
             "Realizar una clase virtual",
             "Registrar tu progreso",
             "Practicar flexibilidad",
             "Hacer ejercicio al aire libre",
             "Bailar por diversión"
        ];

        $tareaCreatividad = [
             "Dibujar algo libremente",
             "Escribir un poema o relato",
             "Improvisar una canción",
             "Crear una fotografía artística",
             "Hacer manualidades",
             "Pintar con acuarelas",
             "Diseñar algo nuevo (ropa, logos, etc.)",
             "Cocinar una receta inventada",
             "Crear memes divertidos",
             "Explorar ideas en Pinterest",
             "Tocar un instrumento",
             "Crear una historia corta",
             "Hacer collage de inspiración",
             "Brainstorming de proyectos",
             "Reorganizar tu espacio"
        ];

        $tareaGestion = [
             "Revisar tu calendario",
             "Organizar tareas por prioridad",
             "Hacer una lista de pendientes",
             "Eliminar tareas innecesarias",
             "Programar tiempo de descanso",
             "Delegar responsabilidades",
             "Establecer objetivos semanales",
             "Limpiar escritorio digital",
             "Revisar metas mensuales",
             "Usar técnica Pomodoro",
             "Archivar documentos importantes",
             "Revisar tus gastos",
             "Marcar tareas completadas",
             "Estimar tiempo por tarea",
             "Identificar interrupciones"
        ];

        $tareaProgramacion = [
             "Escribir al menos 10 líneas de código",
             "Resolver un bug",
             "Aprender una función nueva",
             "Leer documentación técnica",
             "Practicar algoritmos",
             "Crear un pequeño script",
             "Comprobar funcionamiento de componente",
             "Escribir al menos 30 líneas de código",
             "Ver tutorial sobre nuevo lenguaje",
             "Investigar en foro técnico",
             "Testear tu código",
             "Usar una herramienta nueva",
             "Documentar tu proyecto",
             "Reestructurar código antiguo",
             "Subir avances a GitHub"
        ];

        $tareaIdiomas = [
             "Aprender 5 palabras nuevas",
             "Escuchar una canción y traducirla",
             "Leer un artículo breve",
             "Practicar pronunciación",
             "Usar una app de idiomas",
             "Hacer ejercicios de gramática",
             "Escribir un texto corto",
             "Repetir frases clave",
             "Practicar tiempos verbales",
             "Ver una serie con subtítulos",
             "Memorizar verbos irregulares",
             "Practica conversaciones de un tema",
             "Revisar un idioma con tarjetas",
             "Usar el idioma con alguien real",
             "Revisar reglas básicas"
        ];

        $tareaRelajacion = [
             "Meditar 10 minutos",
             "Escuchar sonidos relajantes",
             "Silencia notificaciones 1 hora",
             "Hacer respiración profunda",
             "Encender una vela aromática",
             "Estirarse lentamente",
             "Tomar una siesta breve",
             "Caminar sin móvil",
             "Hacer journaling emocional",
             "Leer algunas páginas de un libro",
             "Tomar un té sin distracciones",
             "Practicar gratitud",
             "Disfrutar el silencio total",
             "Practicar empatia",
             "Observar el cielo por 5 minutos"
        ];

        $tareaBelleza = [
             "Lavar rostro con tu rutina habitual",
             "Aplicar mascarilla facial",
             "Hidratar la piel",
             "Usar protector solar",
             "Cuidar manos y uñas",
             "Probar peinado diferente",
             "Limpiar brochas de maquillaje",
             "Probar nuevo look o outfit",
             "Exfoliar labios o piel",
             "Revisar productos caducados",
             "Revisar puntas del cabello",
             "Practicar posturas de confianza",
             "Evitar maquillaje un día",
             "Probar nuevo estilo de maquillaje",
              "Cuidar el aroma personal"
        ];

        $tareaSocial = [
             "Saludar a tres personas hoy con una sonrisa",
             "Llamar o escribir a alguien con quien no hablas hace tiempo",
             "Proponer una salida o plan a un amigo",
             "Escuchar activamente a alguien sin interrumpir",
             "Hacer un cumplido sincero a alguien",
             "Compartir algo positivo en redes sociales",
             "Apoyar a alguien en su proyecto o idea",
             "Jugar un juego o actividad grupal",
             "Invitar a alguien a tomar algo o charlar",
             "Participar en una comunidad o grupo online",
             "Hacer una videollamada corta para saludar",
             "Preguntar cómo está alguien… y quedarse a escuchar",
             "Dar las gracias con intención a alguien hoy",
             "Ofrecer ayuda a alguien que lo necesite",
             "Recordar un buen momento con alguien y compartirlo"
        ];

    }

    public function run(): void
    {
        self::Categorias();
        $this->command->info('Categorias creadas con éxito');
        
        // User::factory(10) >create();

       /* User::factory() ->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
