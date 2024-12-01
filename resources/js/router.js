// resources/js/router.js
import { createRouter, createWebHistory } from 'vue-router';
import ProductDetails from '../js/Pages/ProductDetails.vue'; // Adjust the path as needed

const routes = [
  {
    path: '/product/:id',
    name: 'productDetails',
    component: ProductDetails,
    props: true, // Pass the route params as props to the component
  },
  // other routes can go here
];

const router = createRouter({
  history: createWebHistory(), // or createWebHashHistory() based on your setup
  routes,
});

export default router;
