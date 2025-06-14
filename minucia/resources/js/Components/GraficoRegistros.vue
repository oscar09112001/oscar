<template>
  <div>
    <canvas ref="canvas" class="w-full max-w-2xl mx-auto" />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const props = defineProps({
  registros: Array
})

const canvas = ref(null)

onMounted(() => {
  // Agrupar por nombre de pieza
  const conteoPorPieza = {}
  props.registros.forEach(r => {
    const nombre = r.pieza?.nombre ?? 'Sin nombre'
    conteoPorPieza[nombre] = (conteoPorPieza[nombre] || 0) + 1
  })

  const labels = Object.keys(conteoPorPieza)
  const data = Object.values(conteoPorPieza)

  new Chart(canvas.value, {
    type: 'bar',
    data: {
      labels,
      datasets: [
        {
          label: 'Cantidad de registros por pieza',
          data,
          backgroundColor: 'rgba(59, 130, 246, 0.6)', // azul
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
})
</script>
