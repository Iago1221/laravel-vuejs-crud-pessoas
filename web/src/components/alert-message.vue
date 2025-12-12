<script setup lang="ts">
  import { onMounted, onUnmounted } from 'vue';

  interface Props {
    message: string;
    type?: 'error' | 'success';
    onClose?: () => void;
  }

  const props = defineProps<Props>();

  let timer: ReturnType<typeof setTimeout>;

  onMounted(() => {
    if (props.onClose) {
      timer = setTimeout(() => {
        props.onClose?.();
      }, 3000);
    }
  });

  onUnmounted(() => {
    clearTimeout(timer);
  });
</script>

<template>
  <div
    v-if="message"
    :class="[
      'fixed top-4 right-4 border p-3 rounded-md shadow-sm z-20',
      type === 'error' ? 'bg-red-300 text-red-800 border-red-500' : 'bg-green-300 text-green-800 border-green-500'
    ]"
  >
    {{ message }}
  </div>
</template>
