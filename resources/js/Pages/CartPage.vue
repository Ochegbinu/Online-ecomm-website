<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import TopNavbar from '@/Components/TopNavbar.vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';

const cartItems = ref([]);
const totalPrice = ref(0);

// Fetch cart items and calculate total price
const fetchCartItems = async () => {
    try {
        const response = await axios.get('/api/my-cart');
        console.log('Full API Response:', response);
        console.log('Response Data:', response.data);
        console.log('Cart Items:', response.data.cartItems);

        if (response.data && response.data.cartItems) {
            cartItems.value = response.data.cartItems;
        } else {
            console.warn('No cart items found in response');
            cartItems.value = [];
        }

        calculateTotal();
    } catch (error) {
        console.error('Error fetching cart items:', error.response ? error.response.data : error);
        cartItems.value = [];
    }
};


// Calculate the total price of items in the cart
const calculateTotal = () => {
    totalPrice.value = cartItems.value.reduce(
        (sum, item) => sum + item.product.discounted_price * item.quantity,
        0
    );
};

// Update the quantity of an item
const updateQuantity = async (item, action) => {
    try {
        const newQuantity = action === 'increment' ? item.quantity + 1 : item.quantity - 1;
        if (newQuantity < 1 || newQuantity > 10) return;

        const response = await axios.put(`/api/cart/${item.id}`, { quantity: newQuantity });
        item.quantity = response.data.updatedQuantity;
        calculateTotal();
    } catch (error) {
        console.error('Error updating quantity:', error);
    }
};

const removeItem = async (itemId) => {
    try {
        await axios.delete(`/api/cart/${itemId}`);

        cartItems.value = cartItems.value.filter((item) => item.id !== itemId);
        window.location.reload();

        calculateTotal();
    } catch (error) {
        console.error('Error removing item:', error);
    }
};


onMounted(fetchCartItems);


</script>

<template>
    <div class="dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
        <TopNavbar />
        <Navbar />

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Cart Items Column (Left) -->
                    <div class="md:col-span-2">
                        <div v-if="cartItems.length > 0" class="space-y-6">
                            <div v-for="item in cartItems" :key="item.id"
                                class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                                <div class="flex items-center space-x-4">
                                    <img :src="item.product.image_path" :alt="item.product.name"
                                        class="w-24 h-24 object-cover rounded-md" />
                                    <div>
                                        <h2 class="font-bold text-lg">{{ item.product.name }}</h2>
                                        <p class="text-sm text-gray-500">{{ item.product.category.name }}</p>
                                        <p class="text-orange-500 font-bold">${{ item.product.discounted_price }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <!-- Quantity Selector -->
                                    <div class="flex items-center border">
                                        <button @click="updateQuantity(item, 'decrement')"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100">-</button>
                                        <span class="px-4 py-2">{{ item.quantity }}</span>
                                        <button @click="updateQuantity(item, 'increment')"
                                            class="px-4 py-2 text-gray-600 hover:bg-gray-100">+</button>
                                    </div>

                                    <!-- Remove Button -->
                                    <DefaultButton @click="removeItem(item.id)">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </DefaultButton>
                                </div>
                            </div>
                        </div>

                        <!-- Empty Cart Message -->
                        <p v-else class="text-center text-gray-500">Your cart is empty.</p>
                    </div>

                    <!-- Order Summary Column (Right) -->
                    <div v-if="cartItems.length > 0" class="md:col-span-1">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md sticky top-8">
                            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                            <div class="flex justify-between mb-4">
                                <p>Subtotal</p>
                                <p>${{ totalPrice.toFixed(2) }}</p>
                            </div>
                            <div class="flex justify-between mb-4">
                                <p>Shipping</p>
                                <p>Free</p>
                            </div>
                            <hr class="mb-4">
                            <div class="flex justify-between font-bold">
                                <p>Total</p>
                                <p>${{ totalPrice.toFixed(2) }}</p>
                            </div>

                            <!-- Checkout Button -->
                            <div class="mt-6">


                                <Link href="/check-out" class="">
                                <PrimaryButton class="w-full">
                                    Proceed to Checkout
                                </PrimaryButton>
                                </Link>
                            </div>


                            <!-- <Link href="/cart"
                            class="flex items-center bg-white border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white py-1 px-4 relative">
                            <i class="fa fa-shopping-cart mr-2"></i>
                            View Cart
                            <span v-if="cartItemCount > 0"
                                class="absolute top-0 right-0 mt-[-6px] mr-[-6px] w-5 h-5 bg-orange-600 text-white text-xs font-bold flex items-center justify-center rounded-full">
                                {{ cartItemCount }}
                            </span>
                        </Link> -->
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
