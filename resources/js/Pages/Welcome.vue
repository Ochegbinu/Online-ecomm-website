<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import CategoryFilter from '../Components/CategoryFilter.vue';
import TopNavbar from '@/Components/TopNavbar.vue';
import axios from 'axios';
import Footer from "../Components/Footer.vue";

const products = ref([]);
const selectedCategories = ref([]);
const cartItemCount = ref(0);

onMounted(async () => {
    try {
        const response = await axios.get('/api/products');
        products.value = response.data;
    } catch (error) {
        console.error("Error fetching products:", error);
    }

    await fetchCartItemCount();  
});

const filteredProducts = computed(() =>
    selectedCategories.value.length > 0
        ? products.value.filter((product) => selectedCategories.value.includes(product.categoryId))
        : products.value
);

// Add product to cart
const addToCart = async (product) => {
    product.isLoading = true;
    try {
        const response = await axios.post('/api/cart', { productId: product.id });
        window.location.reload();
    } catch (error) {
        console.error("Error adding to cart:", error);
        alert("Failed to add product to cart.");
    } finally {
        product.isLoading = false;
    }
};

// Remove product from cart
const removeFromCart = async (productId) => {
    try {
        const response = await axios.delete(`/api/cart/${productId}`);
        cartItemCount.value = response.data.cartItemCount;
        alert('Product removed from cart!');
    } catch (error) {
        console.error("Error removing product from cart:", error);
        alert("Failed to remove product from cart.");
    }
};

// Fetch the number of items in the cart
const fetchCartItemCount = async () => {
    try {
        const response = await axios.get('/api/cart/item-count');
        cartItemCount.value = response.data.count || 0;
    } catch (error) {
        console.error("Error fetching cart item count:", error);
    }
};

// Update selected categories based on the emitted value from CategoryFilter
const setSelectedCategories = (value) => {
    selectedCategories.value = value;
    console.log('Selected Categories:', selectedCategories.value); 
};
</script>

<template>

    <Head title="Product Listing" />
    <div class="dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
        <TopNavbar />
        <Navbar />

        <div class="relative w-full h-[250px]">
            <img src="../assets/hero.jpg" alt="Hero Image" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="absolute ml-[7rem] top-1/2 left-10 transform -translate-y-1/2 text-white">
                <h2 class="text-4xl font-bold">Our <span class="text-orange-500">Shop</span></h2>
                <p class="text-lg mt-2">Home &gt; Shop</p>
            </div>
        </div>

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Filter -->
                    <div>
                        <CategoryFilter @update:filter="setSelectedCategories" />
                    </div>

                    <!-- Products -->
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="product in filteredProducts" :key="product.id"
                                class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden relative">
                                <!-- Wishlist and Cart Icons -->
                                <div class="absolute top-2 right-2 flex space-x-2 z-10">
                                    <button
                                        class="bg-orange-500 hover:bg-orange-700 text-white dark:text-white p-2 shadow"
                                        title="Add to Wishlist">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                    <button
                                        class="bg-orange-500 hover:bg-orange-700 text-white dark:text-white p-2 shadow"
                                        :disabled="product.isLoading" @click.stop="addToCart(product)">
                                        <i v-if="product.isLoading" class="fa fa-spinner fa-spin"></i>
                                        <i v-else class="fa fa-shopping-cart"></i>
                                    </button>
                                </div>

                                <!-- Entire card as a link -->
                                <Link :href="`/products/${product.id}`" class="block">
                                <!-- Product Image -->
                                <img :src="product.image_path" :alt="product.name" class="w-full h-48 object-cover" />

                                <!-- Product Details -->
                                <div class="p-4">
                                    <!-- Product Category -->
                                    <p class="text-sm font-medium text-orange-500 dark:text-gray-400">
                                        {{ product.category.name }}
                                    </p>

                                    <!-- Product Name -->
                                    <span class="text-lg font-bold text-black">
                                        {{ product.name }}
                                    </span>

                                    <!-- Star Rating -->
                                    <div class="flex items-center mt-2 space-x-1">
                                        <span v-for="n in 5" :key="n">
                                            <i
                                                :class="n <= product.average_rating ? 'fa fa-star text-yellow-400' : 'fa fa-star-o text-gray-400'"></i>
                                        </span>
                                    </div>

                                    <!-- Product Price -->
                                    <p class="mt-2 text-sm">
                                        <span class="text-gray-500 line-through"
                                            v-if="product.price !== product.discounted_price">
                                            ${{ product.price }}
                                        </span>
                                        <span class="text-orange-500 font-bold ml-2">
                                            ${{ product.discounted_price }}
                                        </span>
                                    </p>
                                </div>
                                </Link>
                            </div>
                        </div>

                        <p v-if="filteredProducts.length === 0" class="text-center text-gray-500 mt-4">
                            No products found.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
