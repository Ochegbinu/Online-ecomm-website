<script setup>
import { ref, onMounted } from 'vue';
import TopNavbar from '@/Components/TopNavbar.vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';

const orderNumber = ref('');

const generateOrderNumber = () => {
    return `#${Math.floor(1000000 + Math.random() * 9000000)}`;
};

onMounted(() => {
    orderNumber.value = generateOrderNumber();
});
</script>

<template>
    <div class="dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">
        <TopNavbar />
        <Navbar  />

        <main class="flex-grow  flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 text-center">
                <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-lg p-8">
                    <div class="mb-6">
                        <svg 
                            class="mx-auto h-20 w-20 text-green-500" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">
                        Payment Successful!
                    </h1>

                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Thank you for your purchase. Your order has been processed successfully.
                    </p>

                    <div class="bg-gray-100 dark:bg-gray-700  p-4 mb-6">
                        <p class="text-gray-700 dark:text-gray-200">
                            <span class="font-semibold">Order Number:</span> 
                            <span class="text-orange-600 dark:text-orange-400">{{ orderNumber }}</span>
                        </p>
                    </div>

                    <div class="space-y-4">
                        <PrimaryButton 
                            @click="$inertia.visit('/orders')"
                            class="w-full"
                        >
                            View Order Details
                        </PrimaryButton>

                        <Link 
                            href="/" 
                            class="block w-full text-center py-3 px-4 
                                   border border-transparent
                                   text-sm font-medium 
                                   text-gray-700 dark:text-gray-300 
                                   bg-gray-200 dark:bg-gray-700 
                                   hover:bg-gray-300 dark:hover:bg-gray-600 
                                   transition duration-300"
                        >
                            Continue Shopping
                        </Link>
                    </div>
                </div>

                <div class="text-center text-gray-500 dark:text-gray-400 mt-6">
                    <p>Need help? Contact our customer support.</p>
                    <p>Email: uiuxocean@gmail.com | Phone: +91 95744 68870</p>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>