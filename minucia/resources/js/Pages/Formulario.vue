<template>
  <!-- Botón de cierre de sesión fijo en la parte superior derecha -->
  <div class="fixed top-4 right-4 z-50">
    <button
      @click="logout"
      class="text-blue-600 hover:underline bg-white rounded shadow px-4 py-2"
    >
      Volver
    </button>
  </div>

  <!-- Contenedor del formulario principal -->
  <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Registrar pieza</h1>

    <!-- Formulario -->
    <form @submit.prevent="submit">
      
      <!-- Campo: Proyecto -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700">Proyecto</label>
        <select v-model="selectedProyectoId" @change="filtrarPiezas" class="w-full border rounded px-3 py-2">
          <option value="">Seleccione un proyecto</option>
          <option v-for="proyecto in proyectos" :key="proyecto.id" :value="proyecto.id">
            {{ proyecto.nombre }}
          </option>
        </select>
      </div>

      <!-- Campo: Pieza (filtrado dinámicamente según el proyecto) -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700">Pieza</label>
        <select v-model="form.pieza_id" class="w-full border rounded px-3 py-2">
          <option value="">Seleccione una pieza</option>
          <option v-for="pieza in piezasFiltradas" :key="pieza.id" :value="pieza.id">
            {{ pieza.nombre }}
          </option>
        </select>
        <p v-if="form.errors.pieza_id" class="text-red-500 text-sm mt-1">{{ form.errors.pieza_id }}</p>
      </div>

      <!-- Campo: Peso real -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700">Peso real</label>
        <input
          type="number"
          step="0.01"
          v-model="form.peso_real"
          class="w-full border rounded px-3 py-2"
        />
        <p v-if="form.errors.peso_real" class="text-red-500 text-sm mt-1">{{ form.errors.peso_real }}</p>
      </div>

      <!-- Botón para enviar formulario -->
      <div>
        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
          :disabled="form.processing"
        >
          Guardar registro
        </button>
      </div>
    </form>

    <!-- Mensaje flash de éxito -->
    <div v-if="$page.props.flash.success" class="mt-4 text-green-600">
      {{ $page.props.flash.success }}
    </div>
  </div>

  <!-- Enlace a la página de reportes -->
  <div>
    <p class="text-center text-gray-500 mt-4">
      <a href="/reportes" class="text-blue-600 hover:underline">Ver registros</a>
    </p>
  </div>
</template>

<script setup>
// Importaciones necesarias desde Vue e Inertia
import { ref, onMounted } from 'vue'
import { router, useForm, usePage } from '@inertiajs/vue3'

// Acceder a las props globales (como los proyectos) desde la página
const page = usePage()
const proyectos = page.props.proyectos

// Referencia al proyecto seleccionado y a las piezas filtradas
const selectedProyectoId = ref('')
const piezasFiltradas = ref([])

// Formulario reactivo con los campos requeridos
const form = useForm({
  pieza_id: '',
  peso_real: '',
})

// Función que filtra las piezas según el proyecto seleccionado
const filtrarPiezas = () => {
  const proyecto = proyectos.find(p => p.id == selectedProyectoId.value)
  const bloques = proyecto?.bloques ?? []
  piezasFiltradas.value = bloques.flatMap(b => b.piezas ?? [])

  // Reinicia la selección de pieza al cambiar de proyecto
  form.pieza_id = ''
}

// Carga inicial al montar el componente
onMounted(() => {
  if (proyectos.length > 0) {
    // Selecciona el primer proyecto por defecto
    selectedProyectoId.value = proyectos[0].id
    filtrarPiezas()
  }
})

// Función que envía el formulario a la ruta Laravel
const submit = () => {
  form.post(route('formulario.store'))
}

// Función para cerrar sesión
function logout() {
  router.post(route('logout'))
}
</script>