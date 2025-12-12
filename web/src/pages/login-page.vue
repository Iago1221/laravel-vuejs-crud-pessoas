<script setup lang="ts">
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { userApi } from '@/api/user-api';
  import { useAuthStore } from '@/stores/auth';
  import AlertMessage from '@/components/alert-message.vue';
  import InputField from '@/components/input-field.vue';

  const router = useRouter();
  const authStore = useAuthStore();

  const email = ref('');
  const password = ref('');
  const errorMessage = ref('');

  const closeMessageCallback = () => {
    errorMessage.value = '';
  }

  async function login(e) {
    e.preventDefault();

    errorMessage.value = '';
    try {
      const response = await userApi.login(email.value, password.value);
      authStore.setToken(response.data.token);
      router.push('/pessoas');
    } catch (err: any) {
      
      if (err.status == '422') {
        errorMessage.value = "Informe o Email e Senha";
        return;
      }

      if (err.status == '401') {
        errorMessage.value = "Email ou Senha incorretos";
        return;
      }
      
      errorMessage.value = "Ocorreu um erro, tente novamente mais tarde";
    }
  }
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-blue-200 p-4 ">
    <div class="flex flex-col justify-center items-center bg-white p-6 rounded-lg shadow-xl w-full max-w-sm">
      <h1 class="text-xl font-semibold mb-4 text-blue-800">Login</h1>

      <AlertMessage v-if="errorMessage" :message="errorMessage" type="error" :onClose="closeMessageCallback" />
      <form @submit="login">
        <InputField v-model="email" type="email" placeholder="Email" required />
        <InputField v-model="password" type="password" placeholder="Senha" required />

        <button type="submit" class="bg-blue-800 text-white w-full py-2 rounded-md cursor-pointer hover:bg-blue-700">
          Entrar
        </button>
      </form>
    
    </div>
  </div>
</template>
