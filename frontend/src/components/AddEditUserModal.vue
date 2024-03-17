<script setup>
import { FwbModal } from 'flowbite-vue'
import { defineProps, defineEmits, ref, onUpdated } from 'vue'
import { useAuthStore } from '@/stores/auth';

// Access the store & router and their methods
const store = useAuthStore()

// Props.
const props = defineProps({
  showAddEditUserModal: {
    type: Boolean,
    required: true
  },
  user: {
    type: Object,
    default: null
  }
});

// Emits.
const emits = defineEmits(['close']);

// Refs.
const type = ref('add');
const addUserForm = ref({
  name: '',
  email: '',
  notes: ''
});

onUpdated(() => {
  console.log('AddEditUserModal updated');
  if (props.user) {
    // Set the type
    type.value = 'edit';

    // Set the form values
    addUserForm.value = {
      name: props.user.name,
      email: props.user.email,
      notes: props.user.notes
    }
  }
});

// Submit Add User Form
const submitForm = () => {
  console.log('Submit Add User Form');

  // Setup the request options
  const requestOptions = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + store.token
    },
    body: JSON.stringify(addUserForm.value)
  };

  // Determine the url.
  if (type.value === 'add') {
    var url = 'http://127.0.0.1:8000/api/users/create';
  } else {
    var url = 'http://127.0.0.1:8000/api/users/' + props.user.id + '/update';
  }

  // Make the request
  fetch(url, requestOptions)
    .then(async (response) => {
      let data = await response.json();
      console.log(data);

      // Check if the request was successful
      if (response.status === 200) {
        // Reset the form
        addUserForm.value = {
          name: '',
          email: '',
          notes: ''
        };

        // Close the modal
        emit('close');
      } else {
        console.log('Users Add failed');
        console.log(data);
      }
    });
}
</script>

<template>
  <fwb-modal v-if="showAddEditUserModal" @close="$emit('close')">
    <!-- Modal header -->
    <template #header>
      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
        {{ type == 'add' ? 'Add' : 'Edit' }} User
      </h3>
    </template>

    <!-- Modal body -->
    <template #body>
      <div class="relative p-4 w-full max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <form class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">

              <!-- Name -->
              <div class="col-span-2 sm:col-span-1">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Name
                </label>

                <input type="text" name="name" id="name" v-model="addUserForm.name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder="Type users name" required="">
              </div>

              <!-- Email -->
              <div class="col-span-2 sm:col-span-1">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Email
                </label>

                <input type="email" name="email" id="email" v-model="addUserForm.email"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                  placeholder="Type users email" required="">
              </div>

              <!-- Notes -->
              <div class="col-span-2">
                <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Notes
                </label>
                <textarea id="notes" rows="4" v-model="addUserForm.notes"
                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Write users notes here"></textarea>
              </div>
            </div>
          </form>
        </div>
      </div>
    </template>

    <template #footer>
      <button type="submit" @click="submitForm"
        class="mb-4 ml-4 text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
            clip-rule="evenodd"></path>
        </svg>
        {{ type == 'add' ? 'Add' : 'Edit' }} user
      </button>
    </template>
  </fwb-modal>
</template>
