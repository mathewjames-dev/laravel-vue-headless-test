<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth';

// Access the store & router and their methods
const store = useAuthStore()
const router = useRouter();

const login = () => {
  console.log('Login')

  // Setup the request options
  const requestOptions = {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' }
  };

  // Make the request
  fetch('http://127.0.0.1:8000/api/login', requestOptions)
    .then(async (response) => {
      let data = await response.json();

      // Check if the request was successful
      if (response.status === 200) {
        console.log('Login successful');
        console.log(data);

        // Store the token
        store.setToken(data.token);

        // Navigate to /users
        router.push('/users');
      } else {
        console.log('Login failed');
        console.log(data);
      }
    });
}
</script>

<template>
  <main>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="login">
      Login
    </button>
  </main>
</template>