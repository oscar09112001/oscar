<template>
  <!-- Pantalla centrada con fondo gris -->
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
      <!-- Título -->
      <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>

      <!-- Formulario -->
      <form @submit.prevent="submit">
        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Correo electrónico</label>
          <input
            v-model="form.email"
            id="email"
            type="email"
            class="w-full border px-3 py-2 rounded"
            required
          >
          <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">
            {{ form.errors.email }}
          </p>
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
          <label for="password" class="block text-gray-700">Contraseña</label>
          <input
            v-model="form.password"
            id="password"
            type="password"
            class="w-full border px-3 py-2 rounded"
            required
          >
          <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">
            {{ form.errors.password }}
          </p>
        </div>

        <!-- Botón -->
        <div>
          <button
            type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
          >
            Iniciar sesión
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
// Importar herramientas de Vue e Inertia
import { reactive } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

// Formulario reactivo
const form = useForm({
  email: '',
  password: ''
})

// Enviar formulario
const submit = () => {
  form.post('/login', {
    onSuccess: () => {
      // Redirección automática si login es exitoso
    },
    onError: () => {
      // Errores cargan en form.errors
    }
  })
}
</script>
