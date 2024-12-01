<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    isIcon: {
        type: Boolean,
        default: false,
    },
    icon: {
        type: String,
        default: null,
    },
    badge: {
        type: [Number, String],
        default: null,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-orange-500 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-orange-500 hover:border-orange-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <!-- Icon and Badge -->
        <template v-if="isIcon">
            <span class="material-icons text-xl">{{ icon }}</span>
            <span
                v-if="badge"
                class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium leading-none text-white bg-orange-600 rounded-full"
            >
                {{ badge }}
            </span>
        </template>

        <!-- Default Slot for Text -->
        <template v-else>
            <slot />
        </template>
    </Link>
</template>
