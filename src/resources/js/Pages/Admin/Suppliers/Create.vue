<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Form from './Partials/Form.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
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
    phoneTypes: {
        default: []
    },
    emailTypes: {
        default: []
    },
});

const formSub = ref(null);

const submitForm = (form) => {    
    formSub.value = form;
    form.transform((data) => ({
        ...data.supplier,
        cpf: data.supplier.cpf ? data.supplier.cpf.replace(/[^0-9]/g, '') : '',
        cnpj: data.supplier.cnpj ? data.supplier.cnpj.replace(/[^0-9]/g, '') : '',
        addresses: data.addresses,
        contacts: data.contacts,
    })).post(route('admin.suppliers.store'), {
        errorBag: '',
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Fornecedor - Cadastrar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Fornecedor - Cadastrar
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <div class="mb-10 text-right">
                    <ButtonLink :href="route('admin.suppliers.index')">
                        Listar
                    </ButtonLink>
                </div>

                <Form @submitted="submitForm" :stateIndicators="stateIndicators" :retreats="retreats" :supplierTypes="supplierTypes" :states="states" :phoneTypes="phoneTypes" :emailTypes="emailTypes">
                    <template #actions>
                        <PrimaryButton :disabled="formSub && formSub?.processing"  :class="{ 'opacity-10': formSub && formSub?.processing }">
                            Cadastrar
                        </PrimaryButton>
                    </template>
                </Form>                
            </div>
        </div>
    </AppLayout>
</template>
