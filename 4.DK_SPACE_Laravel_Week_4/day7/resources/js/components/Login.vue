<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="submitLogin">
      <input v-model="email" placeholder="Email" type="email" />
      <input v-model="password" placeholder="Password" type="password" />
      <button type="submit">Login</button>
    </form>
    <p v-if="error">{{ error }}</p>
  </div>
</template>

<script>
import api from '../axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: null,
    };
  },
  methods: {
    async submitLogin() {
      try {
        this.error = null;
        await api.get('/sanctum/csrf-cookie'); // lấy CSRF token
        await api.post('/login', {
          email: this.email,
          password: this.password,
        });
        this.$router.push('/');
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed';
      }
    },
  },
};
</script>
