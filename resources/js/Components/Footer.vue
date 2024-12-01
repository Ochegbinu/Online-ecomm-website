<template>
  <footer class="bg-gray-900 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Top Section with Logo and Navigation -->
      <div class="flex flex-col md:flex-row items-center justify-between mb-8">
        <!-- Logo -->
        <div class="flex items-center mb-4 md:mb-0">
          <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center relative">
            <div class="w-4 h-4 bg-black rounded-full flex items-center justify-center">
              <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
            </div>
          </div>
          <span class="ml-3 text-xl font-bold">CKART</span>
        </div>
        <!-- Navigation Links -->
        <nav class="flex flex-wrap justify-center md:justify-end space-x-6">
          <a href="#" class="text-gray-400 hover:text-orange-500 text-sm mb-2 md:mb-0">Home</a>
          <a href="#" class="text-gray-400 hover:text-orange-500 text-sm mb-2 md:mb-0">Shop</a>
          <a href="#" class="text-gray-400 hover:text-orange-500 text-sm mb-2 md:mb-0">About Us</a>
          <a href="#" class="text-gray-400 hover:text-orange-500 text-sm mb-2 md:mb-0">Contact Us</a>
          <a href="#" class="text-gray-400 hover:text-orange-500 text-sm mb-2 md:mb-0">Blog</a>
        </nav>
      </div>

      <!-- Footer Grid Sections -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Info Section -->
        <div>
          <h3 class="text-lg font-semibold mb-3">Info</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-white hover:text-orange-500">Customer Service</a></li>
            <li><a href="#" class="text-white hover:text-orange-500">FAQs</a></li>
            <li><a href="#" class="text-white hover:text-orange-500">Order Tracking</a></li>
          </ul>
        </div>

        <!-- Service Section -->
        <div>
          <h3 class="text-lg font-semibold mb-3">Service</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-white hover:text-orange-500">Sitemap</a></li>
            <li><a href="#" class="text-white hover:text-orange-500">Privacy Policy</a></li>
            <li><a href="#" class="text-white hover:text-orange-500">Terms & Conditions</a></li>
          </ul>
        </div>

        <!-- Account Section -->
        <div>
          <h3 class="text-lg font-semibold mb-3">Account</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-white hover:text-orange-500">My Account</a></li>
            <li><a href="#" class="text-white hover:text-orange-500">Favorites</a></li>
            <li><a href="#" class="text-white hover:text-orange-500">Other</a></li>
          </ul>
        </div>

        <!-- Contact Section -->
        <div>
          <h3 class="text-lg font-semibold mb-3">Contact</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-white hover:text-orange-500"><i class="fa fa-envelope"></i> uiuxocean@gmail.com</a></li>
            <li><a href="#" class="text-white hover:text-orange-500"><i class="fa fa-phone"></i> +91 95744 68870</a></li>
            <li><a href="#" class="text-white hover:text-orange-500"><i class="fa fa-map"></i> Ahmedabad, India</a></li>
          </ul>
        </div>
      </div>

      <!-- Bottom Section -->
      <div class="flex flex-col md:flex-row justify-between items-center mt-8 border-t border-gray-700 pt-6">
        <p class="text-sm text-gray-400 mt-4 md:mt-0">
          &copy; {{ new Date().getFullYear() }} CKART. All rights reserved.
        </p>

        <div class="flex space-x-4 mt-4 md:mt-0">
          <a href="#" class="text-gray-400 hover:text-orange-500"><i class="fa fa-facebook"></i></a>
          <a href="#" class="text-gray-400 hover:text-orange-500"><i class="fa fa-twitter"></i></a>
          <a href="#" class="text-gray-400 hover:text-orange-500"><i class="fa fa-instagram"></i></a>
          <a href="#" class="text-gray-400 hover:text-orange-500"><i class="fa fa-linkedin"></i></a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import "font-awesome/css/font-awesome.min.css";
</script>

<style scoped>
footer a {
  transition: color 0.3s;
}
</style>
