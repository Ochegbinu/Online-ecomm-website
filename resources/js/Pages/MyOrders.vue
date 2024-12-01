<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import TopNavbar from '@/Components/TopNavbar.vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

// Reactive state for orders
const orders = ref([]);
const isLoading = ref(true);
const error = ref(null);

// Fetch orders (carts with items)
onMounted(async () => {
    try {
        const response = await axios.get('/api/orders');
        console.log('Raw response:', response.data); // Log the entire response
        console.log('Response type:', typeof response.data);
        console.log('Is array:', Array.isArray(response.data));

        orders.value = response.data;
        isLoading.value = false;
    } catch (err) {
        console.error("Full error:", err);
        console.error("Error response:", err.response);
        error.value = err.response?.data?.message || "Failed to load orders. Please try again later.";
        isLoading.value = false;
    }
});

// Format date function
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const cancelOrder = async (cartId) => {
    try {
        await axios.put(`/api/orders/${cartId}/cancel`);
        const orderIndex = orders.value.findIndex(order => order.id === cartId);
        if (orderIndex !== -1) {
            orders.value[orderIndex].status = 'Cancelled';
        }
        alert('Order cancelled successfully');
    } catch (err) {
        console.error("Error cancelling order:", err);
        alert('Failed to cancel order');
    }
};

const calculateTotal = (order) => {
    return order.items.reduce((total, item) => total + parseFloat(item.total_price), 0);
};
</script>

<template>

    <Head title="My Orders" />
    <div class="dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
        <TopNavbar />
        <Navbar />

        <!-- Hero Section -->
        <div class="relative w-full h-[250px]">
            <img src="../assets/orders.jpg" alt="Hero Image" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="absolute ml-[7rem] top-1/2 left-10 transform -translate-y-1/2 text-white">
                <h2 class="text-4xl font-bold">My <span class="text-orange-500">Orders</span></h2>
                <p class="text-lg mt-2">Home &gt; My Orders</p>
            </div>
        </div>

        <!-- Main Content -->
        <main class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Loading State -->
            <div v-if="isLoading" class="text-center">
                <i class="fa fa-spinner fa-spin text-4xl text-orange-500"></i>
                <p class="mt-4">Loading your orders...</p>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="text-center text-red-500">
                {{ error }}
            </div>

            <!-- Empty Orders -->
            <div v-else-if="orders.length === 0" class="text-center">
                <i class="fa fa-shopping-bag text-4xl text-gray-400 mb-4 block"></i>
                <p class="text-gray-500">You haven't placed any orders yet.</p>
                <Link href="/" class="mt-4 inline-block bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                Start Shopping
                </Link>
            </div>

            <!-- Orders -->
            <div v-else class="space-y-6">
                <div v-for="order in orders" :key="order.id"
                    class="bg-white dark:bg-gray-800 shadow-lg  w-full overflow-hidden">
                    <!-- Order Header -->
                    <div class="p-4 flex justify-between items-center bg-gray-100 dark:bg-gray-700">
                        <div>
                            <span class="text-orange-500 font-bold text-lg">Order #{{ order.id }}</span>
                            <span class="ml-4 text-sm text-gray-500">
                                Placed on {{ formatDate(order.created_at) }}
                            </span>
                        </div>
                        <span class="text-sm font-medium
                        {{ order.status === 'active' ? 'bg-green-500 text-green-500' : 
                           order.status === 'Cancelled' ? 'text-red-500' : 'text-gray-500' }}">
                            {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                        </span>
                    </div>

                    <!-- Order Items -->
                    <div class="p-4 space-y-4">
                        <div v-for="item in order.items" :key="item.id"
                            class="flex border-b pb-4 dark:border-gray-700 last:border-0">
                            <img :src="item.product.image_path" :alt="item.product.name"
                                class="w-24 h-24 object-cover rounded mr-4" />
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-blue-500">{{ item.product.name }}</h4>
                                    <span class="font-bold text-orange-500">
                                        ${{ parseFloat(item.total_price).toFixed(2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-sm text-gray-500">Quantity: {{ item.quantity }}</span>
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Footer -->
                    <div
                        class="p-4 flex justify-between items-center border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <span class="font-bold text-lg">
                            Total: <span class="text-orange-500">${{ calculateTotal(order).toFixed(2) }}</span>
                        </span>
                        <div class="flex space-x-2">
                            <Link :href="`/orders/${order.id}`"
                                class="flex-1 text-center items-center border-transparent bg-orange-500 px-4 py-2 text-xs font-semibold tracking-widest text-white transition duration-150 ease-in-out hover:bg-orange-400 focus:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-orange-600">
                            View Details
                            </Link>
                            <button @click="cancelOrder(order.id)"
                                v-if="order.status !== 'Cancelled' && order.status !== 'Completed'"
                                class="flex-1 text-center items-center border border-gray-500 bg-white px-4 py-2 text-xs font-semibold tracking-widest text-black transition duration-150 ease-in-out hover:bg-gray-400 focus:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-600">
                                Cancel Order
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
