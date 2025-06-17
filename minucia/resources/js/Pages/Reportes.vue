<template>
   <div class="fixed top-4 right-4 z-50">
    <button
      @click="$inertia.visit('/formulario')"
      class="text-blue-600 hover:underline bg-white rounded shadow px-4 py-2"
    >
      Volver al formulario
    </button>
  </div>
  <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Registros</h1>

    <div v-if="page.props.flash && page.props.flash.success" class="text-green-600 mb-4">
    {{ page.props.flash.success }}
    </div>

    <table class="w-full border">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Usuario</th>
          <th class="border px-4 py-2">Proyecto</th>
          <th class="border px-4 py-2">Bloque</th>
          <th class="border px-4 py-2">Pieza</th>
          <th class="border px-4 py-2">Peso real</th>
          <th class="border px-4 py-2">Fecha</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="registro in registros" :key="registro.id">
          <td class="border px-4 py-2">{{ registro.id }}</td>
          <td class="border px-4 py-2">{{ registro.user?.name }}</td>
          <td class="border px-4 py-2">{{ registro.pieza?.bloque?.proyecto?.nombre }}</td>
          <td class="border px-4 py-2">{{ registro.pieza?.bloque?.nombre }}</td>
          <td class="border px-4 py-2">{{ registro.pieza?.nombre }}</td>
          <td class="border px-4 py-2">{{ registro.peso_real }}</td>
          <td class="border px-4 py-2">{{ new Date(registro.created_at).toLocaleString() }}</td>
        </tr>
      </tbody>
    </table>
    <GraficoRegistros :registros="registros" />
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import GraficoRegistros from '@/Components/GraficoRegistros.vue'

const page = usePage()

const props = defineProps({
  registros: Array,
})


</script>
