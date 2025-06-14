<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
      <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Correo electrónico</label>
          <input v-model="form.email" id="email" type="email" class="w-full border px-3 py-2 rounded" required>
          <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700">Contraseña</label>
          <input v-model="form.password" id="password" type="password" class="w-full border px-3 py-2 rounded" required>
          <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</p>
        </div>
        <div>
          <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Iniciar sesión
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: ''
})

const submit = () => {
  form.post('/login', {
    onSuccess: () => {
      // Redirige automáticamente gracias a middleware 'auth'
    },
    onError: () => {
      // errores ya están en form.errors
    }
})
}
</script>
