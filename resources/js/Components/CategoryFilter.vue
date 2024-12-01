<script setup>
import { ref, watch, onMounted, defineEmits } from 'vue';
import axios from 'axios';

const emit = defineEmits(['update:filter']);

const categories = ref([]);
const selectedCategories = ref([]);

// Fetch categories from the Laravel API
onMounted(async () => {
    try {
        const response = await axios.get('/api/categories');
        categories.value = response.data;
    } catch (error) {
        console.error('Error fetching categories:', error);
    }
});

// Toggle selected categories
const toggleCategory = (id) => {
    if (selectedCategories.value.includes(id)) {
        selectedCategories.value = selectedCategories.value.filter((catId) => catId !== id);
    } else {
        selectedCategories.value.push(id);
    }

    // Emit the updated selected categories
    emit('update:filter', selectedCategories.value);
};
</script>

<template>
    <div class="bg-white dark:bg-orange-500 shadow p-4 rounded-lg p-5">
        <h2 class="text-lg font-bold mb-4">Filter by Category</h2>
        <ul class="space-y-2">
            <li v-for="category in categories" :key="category.id" class="flex items-center">
                <div 
                    :class="[
                        'w-5 h-5 flex items-center justify-center border rounded border-gray-300 cursor-pointer',
                        selectedCategories.includes(category.id) ? 'bg-orange-500' : 'bg-white'
                    ]" 
                    @click="toggleCategory(category.id)"
                >
                    <svg v-if="selectedCategories.includes(category.id)" xmlns="http://www.w3.org/2000/svg"
                        class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <label class="text-sm ml-4 cursor-pointer" @click="toggleCategory(category.id)">
                    {{ category.name }}
                </label>
            </li>
        </ul>
    </div>
</template>