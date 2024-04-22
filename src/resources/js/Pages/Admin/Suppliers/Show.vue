<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Form from './Partials/Form.vue';
import ButtonLink from '@/Components/ButtonLink.vue';

const props = defineProps({
    item: {
        default: null
    },
    supplierTypes: {
        default: []
    },
    stateIndicators: {
        default: []
    },
    retreats: {
        default: []
    },
    states: {
        default: []
    },
    cities: {
        default: []
    },
    phoneTypes: {
        default: []
    },
    emailTypes: {
        default: []
    },
});

</script>

<template>
    <AppLayout title="Fornecedor - Visualizar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Fornecedor - Visualizar
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <div class="mb-10 text-right">
                    <ButtonLink :href="route('admin.suppliers.delete', item.id)">
                        Excluir
                    </ButtonLink>
                    <ButtonLink :href="route('admin.suppliers.edit', item.id)">
                        Editar
                    </ButtonLink>
                    <ButtonLink :href="route('admin.suppliers.create')">
                        Cadastrar
                    </ButtonLink>
                    <ButtonLink :href="route('admin.suppliers.index')">
                        Listar
                    </ButtonLink>
                </div>

                <Form :item="item" :addresses="item.addresses" :contacts="item.contacts" :stateIndicators="stateIndicators" :retreats="retreats" :supplierTypes="supplierTypes" :isDisabled="true" :states="states" :cities="cities" :phoneTypes="phoneTypes" :emailTypes="emailTypes">
                    <template #actions>
                        
                    </template>
                </Form>
            </div>
        </div>
    </AppLayout>
</template>
