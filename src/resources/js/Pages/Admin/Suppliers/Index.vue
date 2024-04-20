<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

defineProps(['items']);

</script>

<template>
    <AppLayout title="Fornecedores">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Fornecedores
            </h2>            
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="mb-6">
                    
                    <div class="w-full text-right">
                        <ButtonLink :href="route('admin.fornecedores.create')">
                            Adicionar
                        </ButtonLink>
                    </div>   
                </div>               

                <div class="bg-white dark:bg-gray-800 overflow-x-auto shadow-xl sm:rounded-lg">
                    
                    <table class="table-auto min-w-full text-left text-sm">
                        <thead class="border-b bg-neutral-50 font-medium dark:border-neutral-500 dark:text-neutral-800">
                            <tr>                                
                                <th scope="col" class="px-6 py-4">Razão Social/Nome</th>
                                <th scope="col" class="px-6 py-4">Nome Fantasia/Apelido</th>
                                <th scope="col" class="px-6 py-4">CNPJ/CPF</th>
                                <th scope="col" class="px-6 py-4">Ativo</th>
                                <th scope="col" class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="items.data.length == 0" class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200">
                                <td colspan="8" class="whitespace-nowrap px-6 py-4">
                                    Nenhum registro encontrado...
                                </td>
                            </tr>
                            <tr v-for="item in items.data" :key="item.id"
                                class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-200"
                            >
                                <td class="whitespace-nowrap px-6 py-4">{{ item.personal_name ?? item.company_name }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ item.nickname ?? item.fantasy_name }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ item.cpf ?? item.cnpj }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ item.status ? 'Sim' : 'Não' }}</td>                                
                                <td class="whitespace-nowrap px-6 py-4">                                    
                                    <div class="ms-3 relative">
                                        <Dropdown>
                                            <template #trigger>
                                                <span class="inline-flex rounded-md">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">                                                    
                                                        <svg class="-me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            </template>

                                            <template #content>
                                                
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Opções
                                                </div>

                                                <DropdownLink :href="route('admin.fornecedores.show', item.id)">
                                                    Ver
                                                </DropdownLink>

                                                <DropdownLink :href="route('admin.fornecedores.edit', item.id)">
                                                    Editar
                                                </DropdownLink>

                                                <div class="border-t border-gray-200" />
                                                
                                                <form @submit.prevent="logout">
                                                    <DropdownLink :href="route('admin.fornecedores.delete', item.id)">
                                                        Excluir
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </Dropdown>
                                    </div>                                    
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div>

                <Pagination v-if="items.data.length > 0" class="mt-6" :links="items.links" />
            </div>
        </div>
    </AppLayout>
</template>
