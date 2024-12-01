<script setup>
import PrimaryButton from './PrimaryButton.vue';
import Navlink from './NavLink.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios'; // For API requests
import { InertiaLink } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3';

const cartItemCount = ref(0);
const isMobileMenuOpen = ref(false); 


const fetchCartItemCount = async () => {
    try {
        const response = await axios.get('/api/cart/item-count');
        cartItemCount.value = response.data.count || 0;
    } catch (error) {
        console.error("Error fetching cart item count:", error);
    }
};

onMounted(() => {
    fetchCartItemCount();
});
</script>

<template>
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div>
                    <div class="mb-6 flex items-center">
                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center relative">
                            <div class="w-4 h-4 bg-white rounded-full flex items-center justify-center">
                                <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                            </div>
                        </div>
                        <span class="ml-3 text-xl font-bold">CKART</span>
                    </div>
                </div>

                <!-- Hamburger Button for Mobile -->
                <button 
                    @click="isMobileMenuOpen = !isMobileMenuOpen" 
                    class="lg:hidden text-gray-500 hover:text-orange-500 focus:outline-none"
                >
                    <i class="fa fa-bars text-xl"></i>
                </button>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden lg:flex items-center space-x-6">
                    <Navlink href="/" :active="true">Home</Navlink>
                    <Navlink href="/shop">Shop</Navlink>
                    <Navlink href="/contact">Contact Us</Navlink>
                    <Navlink href="/about">About Us</Navlink>
                    <Navlink href="/blog">Blog</Navlink>
                </nav>

                <!-- Cart and Auth Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    <div class="flex items-center space-x-4">
                        <Link href="/cart"
                            class="flex items-center bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white py-1 px-4 relative">
                            <i class="fa fa-shopping-cart mr-2"></i>
                            View Cart
                            <span v-if="cartItemCount > 0"
                                class="absolute top-0 right-0 mt-[-6px] mr-[-6px] w-5 h-5 bg-orange-600 text-white text-xs font-bold flex items-center justify-center rounded-full">
                                {{ cartItemCount }}
                            </span>
                        </Link>
                    </div>

                    <div v-if="$page.props.auth.user">
                        <InertiaLink :href="route('logout')" method="post" as="button">
                            <PrimaryButton>Logout</PrimaryButton>
                        </InertiaLink>
                    </div>
                    <div v-else>
                        <Navlink href="/login">
                            <PrimaryButton>Login</PrimaryButton>
                        </Navlink>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div 
                v-show="isMobileMenuOpen" 
                class="lg:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700"
            >
                <nav class="flex flex-col space-y-4 py-4 px-4">
                    <Navlink href="/" :active="true">Home</Navlink>
                    <Navlink href="/shop">Shop</Navlink>
                    <Navlink href="/contact">Contact Us</Navlink>
                    <Navlink href="/about">About Us</Navlink>
                    <Navlink href="/blog">Blog</Navlink>
                </nav>

                <div class="flex flex-col items-center space-y-4 py-4">
                    <Link href="/cart"
                        class="flex items-center bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white py-1 px-4 relative">
                        <i class="fa fa-shopping-cart mr-2"></i>
                        View Cart
                        <span v-if="cartItemCount > 0"
                            class="absolute top-0 right-0 mt-[-6px] mr-[-6px] w-5 h-5 bg-orange-600 text-white text-xs font-bold flex items-center justify-center rounded-full">
                            {{ cartItemCount }}
                        </span>
                    </Link>

                    <div v-if="$page.props.auth.user">
                        <InertiaLink :href="route('logout')" method="post" as="button">
                            <PrimaryButton>Logout</PrimaryButton>
                        </InertiaLink>
                    </div>
                    <div v-else>
                        <Navlink href="/login">
                            <PrimaryButton>Login</PrimaryButton>
                        </Navlink>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
