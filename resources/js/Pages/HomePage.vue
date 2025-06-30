
<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
      <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sales Inventory</h2>


          <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
            <Link href="/login-page" class="text-white-600 hover:text-white-500 font-medium">Start Sale</Link>
          </button>


        
      </div>
    </div>
</template>



<script setup>
import { Link } from '@inertiajs/vue3'
</script>
