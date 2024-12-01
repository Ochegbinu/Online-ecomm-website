<script setup>
import { computed } from 'vue'; // Ensure computed is imported
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

// Computed property to check if both email and password are filled
const isFormValid = computed(() => {
    return form.email !== '' && form.password !== '';
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="flex flex-col md:flex-row min-h-screen">
      <!-- Left side with image -->
      <div class="hidden md:block relative w-1/2">
        <img src="@/assets/hero.jpg" alt="Hero Image" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute top-2/3 left-1/3 transform -translate-x-1/2 text-white text-center">
          <p class="mt-2 text-lg font-serif italic text-2xl opacity-80">𝓛𝓸𝓿𝓮 𝓨𝓸𝓾𝓻 𝓢𝓹𝓪𝓬𝓮</p>
  
          <h2 class="text-4xl font-bold leading-tight">
            <span class="text-orange-500">Elevate</span> Your Space,
            <br />
            Embrace Your <span class="text-orange-500">Style.</span>
          </h2>
        </div>
      </div>
  
      <!-- Right side with form -->
      <div class="w-full md:w-1/2 flex items-center justify-center">
        <form @submit.prevent="submit" class="w-full max-w-md p-6 bg-white">
          <div v-if="status" class="mb-4 text-sm font-medium text-orange-600">
            {{ status }}
          </div>
  
          <!-- Branding -->
          <div class="mb-6 flex items-center justify-center">
            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center relative">
              <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center">
                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
              </div>
            </div>
            <span class="ml-3 text-xl font-bold">CKART</span>
          </div>
  
          <!-- Welcome Back message -->
          <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Welcome Back</h2>
            <p class="text-sm text-gray-600">𝙔𝙤𝙪𝙧 𝙅𝙤𝙪𝙧𝙣𝙚𝙮 𝘼𝙬𝙖𝙞𝙩𝙨—𝙇𝙤𝙜 𝙄𝙣 𝙩𝙤 𝘾𝙤𝙣𝙩𝙞𝙣𝙪𝙚.</p>
          </div>
  
          <!-- Email field -->
          <div>
            <InputLabel for="email" value="Email" />
            <div class="relative">
              <i
                class="fa fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-orange-500"></i>
              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full pl-10"
                v-model="form.email"
                required
                autofocus
                autocomplete="username"
                placeholder="Enter Your Email"
              />
            </div>
            <InputError class="mt-2" :message="form.errors.email" />
          </div>
  
          <!-- Password field -->
          <div class="mt-4">
            <InputLabel for="password" value="Password" />
            <div class="relative">
              <i class="fa fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-orange-500"></i>
              <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full pl-10"
                v-model="form.password"
                required
                autocomplete="current-password"
                placeholder="Enter Your Password"
              />
            </div>
          </div>
  
          <!-- Remember me and Forgot Password -->
          <div class="mt-4 flex justify-between items-center">
            <label class="flex items-center">
              <Checkbox name="remember" v-model:checked="form.remember" />
              <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm text-gray-600 underline hover:text-gray-900"
            >
              Forgot your password?
            </Link>
          </div>
  
          <!-- Submit Button -->
          <div class="mt-4">
            <PrimaryButton
              :class="{
                'opacity-25 bg-orange-600 cursor-not-allowed': form.processing || !isFormValid,
                'bg-orange-500 hover:bg-orange-600': isFormValid && !form.processing
              }"
              :disabled="form.processing || !isFormValid"
              class="w-full"
            >
              Log in &rarr;
            </PrimaryButton>
          </div>
  
          <!-- Register link -->
          <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
              Do not have an account?
              <Link href="/register" class="text-orange-500 underline">Register here</Link>
            </p>
          </div>
        </form>
      </div>
    </div>
  </template>
  
