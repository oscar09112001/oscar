<script setup>
// Importa el layout de usuarios no autenticados y componentes reutilizables
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

// Define el formulario con un solo campo: contraseña
const form = useForm({
    password: '',
})

// Función que se ejecuta al enviar el formulario
const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(), // Limpia el campo al terminar
    })
}
</script>

<template>
    <GuestLayout>
        <!-- Título de la pestaña -->
        <Head title="Confirm Password" />

        <!-- Texto de instrucción -->
        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <!-- Formulario -->
        <form @submit.prevent="submit">
            <!-- Campo contraseña -->
            <div>
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <!-- Mensaje de error si la contraseña está mal -->
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Botón de confirmación -->
            <div class="mt-4 flex justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
