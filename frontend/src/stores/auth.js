import { defineStore } from 'pinia'

export const useAuthStore = defineStore('counter', {
  state: () => ({ token: JSON.parse(localStorage.getItem("token")) }),
  actions: {
    // Your setItem localStorage method
    persistToLocalStorage() {
      localStorage.setItem("token", JSON.stringify(this.token));
    },

    setToken(token) {
      this.token = token;

      this.persistToLocalStorage();
    },
  },
})