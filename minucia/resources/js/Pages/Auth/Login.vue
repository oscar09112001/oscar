<script setup>
// Importa el layout y componentes necesarios para el formulario
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

// Props que vienen del backend (si se puede recuperar contraseña, o un estado de sesión)
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
})

// Datos del formulario de login
const form = useForm({
    email: '',
    password: '',
    remember: false,
})

// Función que se ejecuta al enviar el formulario
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'), // Limpia la contraseña después de enviar
    })
}
</script>

<template>
    <GuestLayout>
        <!-- Título de la pestaña -->
        <Head title="Log in" />

        <!-- Mensaje de estado si existe (por ejemplo: contraseña cambiada) -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <!-- Formulario de inicio de sesión -->
        <form @submit.prevent="submit">
            <!-- Campo de correo -->
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

            <!-- Campo de contraseña -->
            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Recordarme -->
            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <!-- Enlaces y botón -->
            <div class="mt-4 flex items-center justify-end">
                <!-- Enlace para recuperar contraseña -->
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </Link>

                <!-- Botón de envío -->
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
