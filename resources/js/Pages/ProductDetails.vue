<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import axios from 'axios';
import TopNavbar from '@/Components/TopNavbar.vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import DefaultButton from '@/Components/DefaultButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { product, relatedProducts } = usePage().props;

const cartItemCount = ref(0);
const quantity = ref(1);

const incrementQuantity = () => {
    if (quantity.value < 10) { 
        quantity.value++;
    }
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const addToCart = async () => {
    try {
        const response = await axios.post('/api/cart', {
            productId: product.id,
            quantity: quantity.value
        });
        cartItemCount.value = response.data.cartItemCount;
        window.location.reload();  
    } catch (error) {
        console.error("Error adding to cart:", error);
        alert("Failed to add product to cart.");
    }
};



// Buy now function
const buyNow = async () => {
    try {
        const response = await axios.post('/api/checkout', {
            productId: product.id,
            quantity: quantity.value
        });
        window.location.href = response.data.checkoutUrl;
    } catch (error) {
        console.error("Error initiating checkout:", error);
        alert("Failed to proceed to checkout.");
    }
};

// Fetch cart item count on mount
onMounted(async () => {
    try {
        const response = await axios.get('/api/cart/item-count');
        cartItemCount.value = response.data.cartItemCount;
    } catch (error) {
        console.error("Error fetching cart item count:", error);
    }
});


</script>

<template>

    <Head :title="product.name" />
    <div class="dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
        <TopNavbar />
        <Navbar />

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Product Image -->
                    <div>

                        <img :src="product.image_path " :alt="product.name"
                            class="w-full h-96 object-cover rounded-lg shadow-lg" />

                    </div>

                    <!-- Product Details -->
                    <div>
                        <!-- Product Category -->
                        <p class="text-sm font-medium text-gray-500 text-orange-500 mb-2">
                            {{ product.category.name }}
                        </p>

                        <!-- Product Name -->
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ product.name }}
                        </h1>

                        <!-- Star Rating -->
                        <div class="flex items-center mb-4 space-x-1">
                            <span v-for="n in 5" :key="n">
                                <i
                                    :class="n <= product.average_rating ? 'fa fa-star text-yellow-400' : 'fa fa-star-o text-gray-400'"></i>
                            </span>
                            <span class="ml-2 text-gray-600">({{ product.reviews_count }} reviews)</span>
                        </div>

                        <!-- Pricing -->
                        <div class="mb-4">
                            <span v-if="product.price !== product.discounted_price"
                                class="text-gray-500 line-through mr-2">
                                ${{ product.price }}
                            </span>
                            <span class="text-orange-500 font-bold text-2xl">
                                ${{ product.discounted_price }}
                            </span>
                        </div>
                        <hr class="pb-5">
                        <!-- Product Description -->
                        <p class="text-gray-700 dark:text-gray-300 mb-6">
                            {{ product.description }}
                        </p>
                        <hr class="pb-5">

                        <!-- Quantity Selector and Buttons on the same line -->
                        <div class="flex items-center space-x-4 mb-6">
                            <span>Qty</span>
                            <div class="flex items-center border mr-4">
                                <button @click="decrementQuantity" class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                    -
                                </button>
                                <span class="px-4 py-2">{{ quantity }}</span>
                                <button @click="incrementQuantity" class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                    +
                                </button>
                            </div>

                            <!-- Add to Cart and Buy Now Buttons -->
                            <div class="flex space-x-4">
                                <PrimaryButton @click="addToCart">
                                    <span class="ml-2">Add to Cart</span>
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </PrimaryButton>

                                <DefaultButton @click="buyNow">
                                    Buy Now <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

                                </DefaultButton>
                            </div>
                        </div>
                        <hr class="pb-5">
                        <div class="flex justify-between items-center">
                            <p>Estimate delivery time: <b>12-26 days</b></p>
                            <div class="flex space-x-4">
                                <span>SHEAR ON</span> <a href="#" class="hover:text-gray-200"><i
                                        class="fab fa-facebook"></i></a>
                                <a href="#" class="hover:text-gray-200"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="hover:text-gray-200"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="hover:text-gray-200"> <i class="fab fa-pinterest-p"
                                        aria-hidden="true"></i></a>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- Additional Product Information -->
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-4">Product Details</h2>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <p>{{ product.long_description || 'No additional details available.' }}</p>
                    </div>
                </div>

                <!-- Related Products -->
                <div class="mt-12">
                    <h1 class="text-3xl text-center font-bold mb-6">Related Products</h1>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div v-for="relatedProduct in relatedProducts" :key="relatedProduct.id"
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <Link :href="route('products.show', relatedProduct.id)">
                            <img :src="getImageUrl(relatedProduct.image_path)" :alt="relatedProduct.name"
                                class="w-full h-48 object-cover" />
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">{{ relatedProduct.name }}</h3>
                                <p class="text-orange-500 font-bold">${{ relatedProduct.discounted_price }}</p>
                            </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>