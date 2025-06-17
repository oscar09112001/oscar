<script setup>
// Layout y componentes reutilizables
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

// Recibe 'status' desde el backend para mostrar confirmación
defineProps({
    status: {
        type: String,
    },
})

// Define el formulario con el campo email
const form = useForm({
    email: '',
})

// Envío del formulario a la ruta de recuperación
const submit = () => {
    form.post(route('password.email'))
}
</script>

<template>
    <GuestLayout>
        <!-- Título de la pestaña -->
        <Head title="Forgot Password" />

        <!-- Mensaje explicativo -->
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <!-- Mensaje de éxito si se envió el correo -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <!-- Formulario -->
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Botón de envío -->
            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
