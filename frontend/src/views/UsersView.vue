<script setup>
import { onMounted, ref, watch } from 'vue'
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router'
import AddEditUserModal from '../components/AddEditUserModal.vue'

// Access the store & router and their methods
const store = useAuthStore()
const router = useRouter();

// Refs.
const usersOriginal = ref([]);
const users = ref([]);
const showAddEditUserModal = ref(false);
const userToEdit = ref(null);
const search = ref('');

// Mounted lifecycle hook
onMounted(() => {
  console.log('UsersView mounted');

  // Get the users.
  getUsers();
});

// Watcher for the search ref
watch(search, async (newSearchValue, oldSearchValue) => {
  console.log('Search value changed');
  if (newSearchValue.length < 1 && oldSearchValue.length > 0) {
    users.value = usersOriginal.value;
    return;
  } else {
    // Filter the users
    users.value = users.value.filter(user => user.name.toLowerCase().includes(newSearchValue.toLowerCase()));
  }
});

// Get Users
const getUsers = () => {
  console.log('Get Users');

  // Setup the request options
  const requestOptions = {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + store.token
    }
  };

  // Fetch the users
  fetch('http://127.0.0.1:8000/api/users', requestOptions)
    .then(async (response) => {
      let data = await response.json();

      // Check if the request was successful
      if (response.status === 200) {
        // Store the users
        users.value = data.users;
        usersOriginal.value = data.users;
      } else {
        console.log('Users Retrieval failed');
        console.log(data);
      }
    });
}

// Edit User
const editUser = (id) => {
  // Get the user to edit from the users array
  const user = users.value.find(user => user.id === id);

  // Set userToEdit ref
  userToEdit.value = user;

  // Show the modal
  showAddEditUserModal.value = true;
}

// Delete User
const deleteUser = (id) => {
  console.log('Delete User');

  // Setup the request options
  const requestOptions = {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + store.token
    }
  };

  // Make the request
  fetch('http://127.0.0.1:8000/api/users/' + id + '/delete', requestOptions)
    .then(async (response) => {
      let data = await response.json();
      console.log(data);

      // Check if the request was successful
      if (response.status === 200) {
        // Get the users
        getUsers();
      } else {
        console.log('Users Delete failed');
        console.log(data);
      }
    });
}
</script>

<template>
  <div class="col-span-12 overflow-x-auto shadow-md sm:rounded-lg">
    <div
      class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
      <button @click="showAddEditUserModal = true"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 text-center dark:bg-gray-900 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        Add User
      </button>

      <!-- Search -->
      <div
        class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
          <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input type="text" id="table-search-users" v-model="search"
            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search for users">
        </div>
      </div>
    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">
            Name
          </th>

          <th scope="col" class="px-6 py-3">
            Email
          </th>

          <th scope="col" class="px-6 py-3">
            Action
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="user in users" :key="user.id"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
            <div class="ps-3">
              <div class="text-base font-semibold">{{ user.name }}</div>
            </div>
          </th>
          <td class="px-6 py-4">
            {{ user.email }}
          </td>
          <td class="px-6 py-4">
            <div class="flex justify-between gap-4">
              <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>

              <button type="button" @click="editUser(user.id)"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                Edit
              </button>

              <button type="button" @click="deleteUser(user.id)"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <AddEditUserModal :showAddEditUserModal="showAddEditUserModal" :user="userToEdit"
      @close="showAddEditUserModal = false; getUsers();" />
  </div>
</template>
