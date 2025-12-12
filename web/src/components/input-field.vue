<script setup lang="ts">
  import { defineProps, defineEmits } from 'vue';

  interface Props {
    modelValue: string;
    type?: string;
    placeholder?: string;
    required?: boolean;

    numeric?: boolean;
    maxLength?: string;
    mask?: ((value: string) => string) | null;
  }

  const props = defineProps<Props>();

  const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
  }>();

  function onInput(e: Event) {
    let value = (e.target as HTMLInputElement).value;

    if (props.numeric) {
      value = value.replace(/\D+/g, '');
    }

    if (props.maxLength) {
      value = value.substring(0, props.maxLength);
    }

    if (props.mask) {
      value = props.mask(value);
    }

    emit('update:modelValue', value);
    (e.target as HTMLInputElement).value = value;
  }
</script>

<template>
  <input
    :type="props.type || 'text'"
    :placeholder="props.placeholder"
    :value="props.modelValue"
    :required="props.required"
    @input="onInput"
    class="border border-blue-800 rounded-md p-2 w-full mb-3 disabled:cursor-not-allowed disabled:bg-gray-200"
  />
</template>
