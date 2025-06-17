<script setup>
// Importaciones necesarias
import { computed } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

// Recibe el estado de verificación desde el backend
const props = defineProps({
    status: {
        type: String,
    },
})

// Formulario vacío para reenviar el correo
const form = useForm({})

// Función que se ejecuta al dar clic en "Resend"
const submit = () => {
    form.post(route('verification.send'))
}

// Verifica si ya se envió el correo de verificación
const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
)
</script>

<template>
    <GuestLayout>
        <!-- Título de la página -->
        <Head title="Email Verification" />

        <!-- Instrucciones -->
        <div class="mb-4 text-sm text-gray-600">
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you? If you
            didn't receive the email, we will gladly send you another.
        </div>

        <!-- Mensaje si ya se envió un nuevo enlace -->
        <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <!-- Formulario con botón para reenviar correo y cerrar sesión -->
        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <!-- Botón reenviar verificación -->
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </PrimaryButton>

                <!-- Botón para cerrar sesión -->
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Log Out
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
