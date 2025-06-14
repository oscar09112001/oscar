<template>
  <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Registrar pieza</h1>

    <form @submit.prevent="submit">
      <!-- Proyecto -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700">Proyecto</label>
        <select v-model="selectedProyectoId" @change="filtrarPiezas" class="w-full border rounded px-3 py-2">
          <option value="">Seleccione un proyecto</option>
          <option v-for="proyecto in proyectos" :key="proyecto.id" :value="proyecto.id">
            {{ proyecto.nombre }}
          </option>
        </select>
      </div>

      <!-- Pieza -->
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

      <!-- Peso real -->
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

      <!-- Botón -->
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

    <!-- Flash message -->
    <div v-if="$page.props.flash.success" class="mt-4 text-green-600">
      {{ $page.props.flash.success }}
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted} from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'



const page = usePage()
const proyectos = page.props.proyectos

const selectedProyectoId = ref('')
const piezasFiltradas = ref([])

const form = useForm({
  pieza_id: '',
  peso_real: '',
})

const filtrarPiezas = () => {
  const proyecto = proyectos.find(p => p.id == selectedProyectoId.value)
  const bloques = proyecto?.bloques ?? []
  piezasFiltradas.value = bloques.flatMap(b => b.piezas ?? [])
  if (piezasFiltradas.value.length > 0) {
    form.pieza_id = piezasFiltradas.value[0].id
  } else {
    form.pieza_id = ''
  }
  form.pieza_id = '' // reiniciar selección
}
onMounted(() => {
  if (proyectos.length > 0) {
    selectedProyectoId.value = proyectos[0].id
    filtrarPiezas()
  }
})

const submit = () => {
  form.post(route('formulario.store'))
}
</script>
