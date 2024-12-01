<script setup>
import Navbar from '@/Components/Navbar.vue';
import TopNavbar from '@/Components/TopNavbar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import DefaultButton from '@/Components/DefaultButton.vue';
import Footer from '@/Components/Footer.vue';
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone,
    company: user.company
});
</script>

<template>
    <Head title="Dashboard" />
    <TopNavbar />
    <Navbar />

    <div class="relative w-full h-[250px]">
        <img src="../assets/dash.jpg" alt="Hero Image" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <div class="absolute ml-4 sm:ml-[7rem] top-1/2 left-10 transform -translate-y-1/2 text-white">
            <h2 class="text-3xl sm:text-4xl font-bold">My <span class="text-orange-500">Account</span></h2>
            <p class="text-base sm:text-lg mt-2">Home &gt; My Account</p>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column: List of navigation options -->
            <div class="hidden lg:block lg:col-span-4">
                <div class="space-y-4">
                    <div class="bg-white p-6 shadow">
                        <ul class="space-y-2">
                            <li>
                                <Link href="#" class="bg-orange-500 text-white py-2 px-4 w-full block">
                                    <i class="fas fa-user-friends"></i> My Account
                                </Link>
                            </li>
                            <li>
                                <Link href="/orders" class="py-2 px-4 rounded-md w-full block">
                                    <i class="fas fa-dolly text-orange-500"></i> My Order
                                </Link>
                            </li>
                            <li>
                                <Link href="#" class="py-2 px-4 rounded-md w-full block">
                                    <i class="fas fa-minus-square text-orange-500"></i> Payments Options
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column: Profile form in a card -->
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">My Profile</h2>
                        <hr class="mt-3">
                    </header>

                    <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
                        <!-- Name and Email Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                        </div>

                        <!-- Phone and Company Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="phone" value="Phone Number" />
                                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required autocomplete="tel" />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <div>
                                <InputLabel for="company" value="Company Name (Optional)" />
                                <TextInput id="company" type="text" class="mt-1 block w-full" v-model="form.company" autocomplete="company" />
                                <InputError class="mt-2" :message="form.errors.company" />
                            </div>
                        </div>

                        <!-- Email Verification -->
                        <div v-if="mustVerifyEmail && user.email_verified_at === null">
                            <p class="mt-2 text-sm text-gray-800">
                                Your email address is unverified.
                                <Link :href="route('verification.send')" method="post" as="button" class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Click here to re-send the verification email.
                                </Link>
                            </p>
                            <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                                A new verification link has been sent to your email address.
                            </div>
                        </div>

                        <!-- Save and Change Password Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>
                            <DefaultButton>Change Password</DefaultButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <Footer />
</template>

