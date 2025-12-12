<script setup lang="ts">
  import { ref, onMounted, computed } from "vue";
  import { Pessoa } from "@/types/pessoa";
  import { pessoaApi } from "@/api/pessoa-api";
  import AlertMessage from "@/components/alert-message.vue";
  import InputField from "@/components/input-field.vue";
  import BaseLayout from "@/layouts/base-layout.vue";
  import TrashIcon from '@/assets/icons/trash.svg?component';
  import PencilIcon from '@/assets/icons/pencil.svg?component';
  import PlusIcon from "@/assets/icons/plus.svg?component";
  import CaretLeftIcon from "@/assets/icons/caret-left.svg?component";
  import CaretRightIcon from "@/assets/icons/caret-right.svg?component";
  import UsersIcon from "@/assets/icons/users.svg?component";

  const pessoas = ref<Pessoa[]>([]);
  const showForm = ref(false);
  const deleteForm = ref(false);
  const deleteId  = ref<number | null>(null);
  const editingPessoa = ref<Pessoa | null>(null);
  const alertMessage = ref("");
  const alertType = ref<"success" | "error">("success");

  const nome = ref("");
  const tipo = ref("fisica");
  const documento = ref("");
  const telefone = ref("");
  const email = ref("");

  async function load() {
    try {
      const { data } = await pessoaApi.list();
      pessoas.value = data.pessoas;
    } catch (err: any) {
      alertMessage.value = "Erro ao carregar pessoas";
      alertType.value = "error";
    }
  }

  function deletePessoa(p: Pessoa) {
    deleteId.value = p.id;
    deleteForm.value = true; 
  }

  function addPessoa() {
    alertMessage.value = "";
    editingPessoa.value = null;
    nome.value = "";
    tipo.value = "fisica";
    documento.value = "";
    telefone.value = "";
    email.value = "";
    showForm.value = true;
  }

  function editPessoa(p: Pessoa) {
    alertMessage.value = "";
    editingPessoa.value = p;
    nome.value = p.nome;
    tipo.value = p.tipo;
    documento.value = maskCpfCnpj(p.documento);
    telefone.value = maskTelefone(p.telefone);
    email.value = p.email;
    showForm.value = true;
  }

  async function remove() {
    try {
      if (!deleteId.value) {
        return;
      }
      
      await pessoaApi.delete(deleteId.value);
      alertMessage.value = "Pessoa excluída com sucesso!";
      alertType.value = "success";

      deleteId.value = null;
      deleteForm.value = false;
      await load();
    } catch {
      alertMessage.value = "Erro ao excluir pessoa!";
      alertType.value = "error";
    }
  }

  async function savePessoa(e) {
    e.preventDefault();

    try {
      if (editingPessoa.value) {
        await pessoaApi.update(
          editingPessoa.value.id,
          nome.value,
          telefone.value.replace(/\D+/g, ''),
          email.value
        );
        alertMessage.value = "Pessoa atualizada com sucesso!";
      } else {
        await pessoaApi.create(
          nome.value,
          tipo.value,
          documento.value.replace(/\D+/g, ''),
          telefone.value.replace(/\D+/g, ''),
          email.value
        );
        alertMessage.value = "Pessoa criada com sucesso!";
      }

      alertType.value = "success";
      showForm.value = false;
      await load();
    } catch (err: any) {
      const status = err?.response?.status;
      const message = err?.response?.data?.error;

      if (status >= 400 && status <= 500) {
        alertMessage.value = message || "Erro de validação!";
        alertType.value = "error";
        return;
      }

      alertMessage.value = "Erro ao salvar pessoa!";
      alertType.value = "error";
    }
  }

  function closeAlert() {
    alertMessage.value = "";
  }

  const currentPage = ref(1);
  const itemsPerPage = ref(5);

  const totalPages = computed(() =>
    Math.ceil(pessoas.value.length / itemsPerPage.value)
  );

  const paginatedPessoas = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return pessoas.value.slice(start, start + itemsPerPage.value);
  });

  function goToPage(page: number) {
    if (page < 1 || page > totalPages.value) return;
    currentPage.value = page;
  }

  function nextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++;
  }

  function previousPage() {
    if (currentPage.value > 1) currentPage.value--;
  }

  function maskCpfCnpj(value: string): string {
    value = value.replace(/\D/g, "");

    if (value.length <= 11) {
      return value
        .replace(/^(\d{3})(\d)/, "$1.$2")
        .replace(/^(\d{3})\.(\d{3})(\d)/, "$1.$2.$3")
        .replace(/\.(\d{3})(\d)/, ".$1-$2")
        .substring(0, 14);
    }

    return value
      .replace(/^(\d{2})(\d)/, "$1.$2")
      .replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
      .replace(/\.(\d{3})(\d)/, ".$1/$2")
      .replace(/(\d{4})(\d)/, "$1-$2")
      .substring(0, 18);
  }

  function maskTelefone(value: string): string {
    value = value.replace(/\D/g, "");

    if (value.length <= 10) {
      return value
        .replace(/^(\d{2})(\d)/, "($1) $2")
        .replace(/(\d{4})(\d)/, "$1-$2")
        .substring(0, 14);
    }

    return value
      .replace(/^(\d{2})(\d)/, "($1) $2")
      .replace(/(\d{5})(\d)/, "$1-$2")
      .substring(0, 15);
  }

  onMounted(load);
</script>

<template>
  <BaseLayout>
    <div class="p-6">
      <AlertMessage 
        v-if="alertMessage" 
        :message="alertMessage" 
        :type="alertType" 
        :onClose="closeAlert"
      />
      
      <div class="flex flex-row justify-start items-center mb-4 space-x-2">
        <UsersIcon class="w-6 h-6 fill-gray-700" />
        <h2 class="text-xl text-gray-700">Pessoas</h2>
      </div>
      

      <button
        class="
          flex flex-row justify-center
          items-center mb-4 bg-white text-green-500 
          px-4 py-1 rounded hover:bg-gray-100 
          border border-gray-800 cursor-pointer"
        @click="addPessoa"
      >
        <PlusIcon class="w-4 h-4 fill-green-500 mr-2" />
        Adicionar
      </button>

      <table class="w-full border border-gray-300 rounded-lg shadow-md">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="p-2 border-b text-center">Nome</th>
            <th class="p-2 border-b text-center">Tipo</th>
            <th class="p-2 border-b text-center">Documento</th>
            <th class="p-2 border-b text-center">Telefone</th>
            <th class="p-2 border-b text-center">Email</th>
            <th class="p-2 border-b text-center">Ações</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="p in paginatedPessoas"
            :key="p.id"
            class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition"
          >
            <td class="p-2 text-center">{{ p.nome }}</td>
            <td class="p-2 text-center">{{ p.tipo == 'fisica' ? 'Física' : 'Jurídica' }}</td>
            <td class="p-2 text-center">{{ maskCpfCnpj(p.documento) }}</td>
            <td class="p-2 text-center">{{ maskTelefone(p.telefone) }}</td>
            <td class="p-2 text-center">{{ p.email }}</td>

            <td class="p-2 flex justify-center gap-2">
              <button
                @click="editPessoa(p)"
                class="inline-flex items-center justify-center cursor-pointer transition group w-6 h-6 p-1 rounded"
                title="Editar"
              >
                <PencilIcon class="w-4 h-4 fill-yellow-500" />
              </button>

              <button
                @click="deletePessoa(p)"
                class="inline-flex items-center justify-center cursor-pointer transition group w-6 h-6 p-1 rounded"
                title="Excluir"
              >
                <TrashIcon class="w-4 h-4 fill-red-500" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="flex justify-center items-center mt-4 gap-2">
        <button
          @click="previousPage"
          :disabled="currentPage === 1"
          class="px-1 py-1 bg-gray-200 rounded disabled:opacity-50 cursor-pointer disabled:cursor-not-allowed"
        >
          <CaretLeftIcon class="w-3 h-3 fill-current" />
        </button>

        <button
          v-for="page in totalPages"
          :key="page"
          @click="goToPage(page)"
          :class="[
            'px-3 py-1 rounded cursor-pointer border',
            currentPage === page
              ? 'bg-blue-800 text-white border-blue-800'
              : 'bg-white hover:bg-gray-100'
          ]"
        >
          {{ page }}
        </button>

        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-1 py-1 bg-gray-200 rounded disabled:opacity-50 cursor-pointer disabled:cursor-not-allowed"
        >
        <CaretRightIcon class="w-3 h-3 fill-current" />
        </button>
      </div>

      <div v-if="deleteForm" class="fixed inset-0 bg-opacity-30 backdrop-blur-xs flex items-center justify-center z-10">
        <div class="border border-blue-800 rounded-md bg-white p-6 shadow-xl w-full max-w-md relative">
          <h2 class="text-lg font-semibold mb-4">Deseja realmente excluir esta pessoa?</h2>
          <div class="mt-4 flex justify-end gap-2">
            <button type="button" @click="deleteForm = false" class="bg-gray-300 px-4 py-1 rounded-md hover:bg-gray-200 cursor-pointer">Cancelar</button>
            <button type="button" @click="remove()" class="bg-blue-800 text-white px-4 py-1 rounded-md hover:bg-blue-700 cursor-pointer">Confirmar</button>
          </div>
        </div>
      </div>

      <div v-if="showForm" class="fixed inset-0 bg-opacity-30 backdrop-blur-xs flex items-center justify-center z-10">
        <div class="border border-blue-800 rounded-md bg-white p-6 shadow-xl w-full max-w-md relative">
          <form @submit="savePessoa">
            <h2 class="text-lg font-semibold mb-4">{{ editingPessoa ? 'Editar Pessoa' : 'Adicionar Pessoa' }}</h2>

            <InputField v-model="nome" placeholder="Nome" required />
            <select v-model="tipo" class="border border-blue-800 rounded-md p-2 w-full mb-3 disabled:cursor-not-allowed disabled:bg-gray-200" :disabled="!!editingPessoa">
              <option value="fisica" :selected="!!editingPessoa && tipo == 'fisica'">Física</option>
              <option value="juridica" :selected="!!editingPessoa && tipo == 'juridica'">Jurídica</option>
            </select>
            <InputField v-model="documento" placeholder="Documento" required :disabled="!!editingPessoa" numeric maxLength="14" :mask="maskCpfCnpj" />
            <InputField v-model="telefone" placeholder="Telefone" required numeric maxLength="11" :mask="maskTelefone" />
            <InputField v-model="email" type="email" placeholder="Email" required />

            <div class="mt-4 flex justify-end gap-2">
              <button type="button" @click="showForm = false" class="bg-gray-300 px-4 py-1 rounded-md hover:bg-gray-200 cursor-pointer">Cancelar</button>
              <button type="submit" class="bg-blue-800 text-white px-4 py-1 rounded-md hover:bg-blue-700 cursor-pointer">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </BaseLayout>
</template>
