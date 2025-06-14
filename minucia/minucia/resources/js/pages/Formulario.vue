<template>
  <div class="max-w-3xl mx-auto p-6 mt-10 bg-white shadow-xl rounded-2xl">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Registro de Piezas</h1>

    <form @submit.prevent="submit" class="space-y-5">
      <!-- Proyecto -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Proyecto</label>
        <select v-model="selectedProyecto" @change="filtrarBloques"
                class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
          <option value="">Seleccione un proyecto</option>
          <option v-for="proyecto in proyectos" :key="proyecto.id" :value="proyecto.id">
            {{ proyecto.nombre }}
          </option>
        </select>
      </div>

      <!-- Bloque -->
      <div v-if="bloques.length">
        <label class="block text-sm font-medium text-gray-700 mb-1">Bloque</label>
        <select v-model="selectedBloque" @change="filtrarPiezas"
                class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
          <option value="">Seleccione un bloque</option>
          <option v-for="bloque in bloques" :key="bloque.id" :value="bloque.id">
            {{ bloque.nombre }}
          </option>
        </select>
      </div>

      <!-- Pieza -->
      <div v-if="piezas.length">
        <label class="block text-sm font-medium text-gray-700 mb-1">Pieza</label>
        <select v-model="selectedPieza" @change="mostrarPesoTeorico"
                class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
          <option value="">Seleccione una pieza</option>
          <option v-for="pieza in piezas" :key="pieza.id" :value="pieza.id">
            {{ pieza.nombre }}
          </option>
        </select>
      </div>

      <!-- Peso Teórico -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Peso Teórico</label>
        <input type="text" :value="pesoTeorico" readonly
               class="w-full bg-gray-100 border border-gray-300 p-2 rounded-lg text-gray-600" />
      </div>

      <!-- Peso Real -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Peso Real</label>
        <input type="number" v-model.number="pesoReal" required
               class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" />
      </div>

      <!-- Diferencia -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Diferencia</label>
        <input type="text" :value="diferenciaPeso" readonly
               class="w-full bg-gray-100 border border-gray-300 p-2 rounded-lg text-gray-600" />
      </div>

      <!-- Botón -->
      <div>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
          Registrar
        </button>
      </div>

      <!-- Errores -->
      <div v-if="errores.length" class="mt-4">
        <ul class="text-red-600 list-disc pl-5">
          <li v-for="(error, index) in errores" :key="index">{{ error }}</li>
        </ul>
      </div>

      <!-- Éxito -->
      <div v-if="success" class="mt-4 text-green-600 font-medium">
        {{ success }}
      </div>
    </form>
  </div>
</template>


<script setup>
import { ref, computed, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const proyectos = ref(page.props.proyectos);

const selectedProyecto = ref('');
const selectedBloque = ref('');
const selectedPieza = ref('');

const bloques = ref([]);
const piezas = ref([]);
const pesoTeorico = ref(0);
const pesoReal = ref(null);
const errores = ref([]);
const success = ref(page.props.flash?.success || '');

watch(pesoReal, () => {
  calcularDiferencia();
});

function filtrarBloques() {
  const proyecto = proyectos.value.find(p => p.id == selectedProyecto.value);
  bloques.value = proyecto ? proyecto.bloques : [];
  piezas.value = [];
  selectedBloque.value = '';
  selectedPieza.value = '';
  pesoTeorico.value = 0;
  pesoReal.value = null;
}

function filtrarPiezas() {
  const bloque = bloques.value.find(b => b.id == selectedBloque.value);
  piezas.value = bloque ? bloque.piezas.filter(p => p.estado === 'Pendiente') : [];
  selectedPieza.value = '';
  pesoTeorico.value = 0;
  pesoReal.value = null;
}

function mostrarPesoTeorico() {
  const pieza = piezas.value.find(p => p.id == selectedPieza.value);
  pesoTeorico.value = pieza ? pieza.peso_teorico : 0;
  calcularDiferencia();
}

const diferenciaPeso = computed(() => {
  if (!pesoReal.value || !pesoTeorico.value) return 0;
  return (pesoReal.value - pesoTeorico.value).toFixed(2);
});

function calcularDiferencia() {
  diferenciaPeso.value = pesoReal.value && pesoTeorico.value ? pesoReal.value - pesoTeorico.value : 0;
}

function submit() {
  errores.value = [];

  if (!selectedPieza.value || !pesoReal.value) {
    errores.value.push('Todos los campos son obligatorios.');
    return;
  }

  if (isNaN(pesoReal.value)) {
    errores.value.push('El peso real debe ser un número.');
    return;
  }

  const form = useForm({
    pieza_id: selectedPieza.value,
    peso_real: pesoReal.value
  });

  form.post('/formulario', {
    preserveScroll: true,
    onError: e => {
      errores.value = Object.values(e);
    },
    onSuccess: () => {
      success.value = 'Registro guardado exitosamente';
      pesoReal.value = null;
      selectedPieza.value = '';
      pesoTeorico.value = 0;
    }
  });
}
</script>

<style scoped>
input, select {
  transition: border 0.3s;
}
input:focus, select:focus {
  border-color: #3b82f6;
  outline: none;
}
</style>
