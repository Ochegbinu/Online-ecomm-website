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

// Billing information form object
const billingInfo = ref({
    fullName: '',
    email: '',
    phone: '',
    company: '',
    address: '',
    country: '',
    state: '',
    city: '',
    zipCode: ''
});

// Payment method selection
const paymentMethod = ref('card'); // default payment method
const paymentMethods = ref(['card', 'paypal', 'bank_transfer', 'cash_on_delivery']); // available methods

// Additional information form object
const additionalInfo = ref('');

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
        console.error('Error fetching cart items:', error.response ? error.response.data : error.message);
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

// Remove an item from the cart
const removeItem = async (itemId) => {
    try {
        await axios.delete(`/api/cart/${itemId}`);
        cartItems.value = cartItems.value.filter((item) => item.id !== itemId);
        calculateTotal();
    } catch (error) {
        console.error('Error removing item:', error);
    }
};

// Proceed to checkout
const checkout = async () => {
    try {
        const response = await axios.post('/api/checkout', {
            paymentMethod: paymentMethod.value,
            billingInfo: billingInfo.value,
            additionalInfo: additionalInfo.value
        });
        window.location.href = response.data.checkoutUrl;
    } catch (error) {
        console.error('Error initiating checkout:', error);
        alert('Failed to proceed to checkout.');
    }
};

// Fetch cart items on mount
onMounted(fetchCartItems);

// Utility function for image paths
const getImageUrl = (imagePath) => {
    return imagePath.startsWith('http') ? imagePath : `/storage/${imagePath}`;
};
</script>

<template>
    <div class="dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
        <TopNavbar />
        <Navbar />

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold mb-6">Checkout</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Checkout Form Column (Left) -->
                    <div class="md:col-span-2 space-y-8">
                        <!-- Billing Information -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                            <h2 class="text-xl font-bold mb-4">Billing Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2">Full Name</label>
                                    <input v-model="billingInfo.fullName" type="text"
                                        class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                        placeholder="Enter your full name" required />

                                </div>
                                <div>
                                    <label class="block mb-2">Email</label>
                                    <input v-model="billingInfo.email" type="email"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your email" required />
                                </div>
                                <div>
                                    <label class="block mb-2">Phone Number</label>
                                    <input v-model="billingInfo.phone" type="tel"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your phone number" required />
                                </div>
                                <div>
                                    <label class="block mb-2">Company Name</label>
                                    <input v-model="billingInfo.company" type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your company name" />
                                </div>
                                <div>
                                    <label class="block mb-2">Address</label>
                                    <input v-model="billingInfo.address" type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your address" required />
                                </div>
                                <div>
                                    <label class="block mb-2">Country</label>
                                    <input v-model="billingInfo.country" type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your country" required />
                                </div>
                                <div>
                                    <label class="block mb-2">State</label>
                                    <input v-model="billingInfo.state" type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your state" required />
                                </div>
                                <div>
                                    <label class="block mb-2">City</label>
                                    <input v-model="billingInfo.city" type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your city" required />
                                </div>
                                <div>
                                    <label class="block mb-2">Zip Code</label>
                                    <input v-model="billingInfo.zipCode" type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your zip code" required />
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                            <h2 class="text-xl font-bold mb-4">Payment Information</h2>
                            <div class="mb-4">
                                <label class="block mb-2">Select Payment Method</label>
                                <select v-model="paymentMethod"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500">
                                    <option v-for="method in paymentMethods" :key="method" :value="method">
                                        {{ method.charAt(0).toUpperCase() + method.slice(1).replace('_', ' ') }}
                                    </option>
                                </select>
                            </div>
                            <div v-if="paymentMethod === 'card'">
                                <!-- Card Details (Example) -->
                                <div class="mb-4">
                                    <label class="block mb-2">Card Number</label>
                                    <input type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your card number" />
                                </div>
                                <div class="mb-4">
                                    <label class="block mb-2">Expiration Date</label>
                                    <input type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="MM/YY" />
                                </div>
                                <div class="mb-4">
                                    <label class="block mb-2">CVV</label>
                                    <input type="text"
                                    class="w-full p-2 border border-orange-500 focus:border-orange-500"
                                    placeholder="Enter your CVV" />
                                </div>
                            </div>
                            <div v-if="paymentMethod === 'paypal'">
                                <p>Redirect to PayPal for payment.</p>
                            </div>
                            <div v-if="paymentMethod === 'bank_transfer'">
                                <p>Bank Transfer details will be provided after checkout.</p>
                            </div>
                            <div v-if="paymentMethod === 'cash_on_delivery'">
                                <p>Pay with cash on delivery.</p>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                            <h2 class="text-xl font-bold mb-4">Additional Information</h2>
                            <textarea v-model="additionalInfo" rows="4"
                            class="w-full p-2 border border-orange-500 focus:border-orange-500"
                            placeholder="Enter any additional notes or instructions"></textarea>
                        </div>
                    </div>

                    <!-- Cart Summary (Right) -->
                    <div>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                            <h2 class="text-xl font-bold mb-4">Cart Summary</h2>
                            <ul class="space-y-4">
                                <li v-for="item in cartItems" :key="item.id" class="flex justify-between items-center">
                                    <span>{{ item.product.name }} ({{ item.quantity }})</span>
                                    <span>${{ (item.product.discounted_price * item.quantity).toFixed(2) }}</span>
                                </li>
                            </ul>
                            <div class="mt-4 border-t pt-4">
                                <div class="flex justify-between">
                                    <span class="font-bold">Total:</span>
                                    <span class="font-bold">${{ totalPrice.toFixed(2) }}</span>
                                </div>
                                <PrimaryButton @click="checkout" class="mt-4 w-full">Proceed to Checkout</PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
