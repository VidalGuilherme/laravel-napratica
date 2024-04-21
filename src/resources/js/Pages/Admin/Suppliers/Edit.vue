<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Form from './Partials/Form.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

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
});

const formSub = ref(null);

const submitForm = (form) => {
    formSub.value = form;
    form.transform((data) => ({
        ...data.supplier,
        cpf: data.supplier.cpf.replace(/[^0-9]/g, ''),
        cnpj: data.supplier.cnpj.replace(/[^0-9]/g, ''),
    })).put(route('admin.suppliers.update', props.item), {
        errorBag: '',
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Fornecedor - Editar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Fornecedor - Editar
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <div class="mb-10 text-right">
                    <ButtonLink :href="route('admin.suppliers.delete', item.id)">
                        Excluir
                    </ButtonLink>
                    <ButtonLink :href="route('admin.suppliers.show', item.id)">
                        Visualizar
                    </ButtonLink>
                    <ButtonLink :href="route('admin.suppliers.create')">
                        Cadastrar
                    </ButtonLink>
                    <ButtonLink :href="route('admin.suppliers.index')">
                        Listar
                    </ButtonLink>
                </div>

                <Form @submitted="submitForm" :item="item" :stateIndicators="stateIndicators" :retreats="retreats" :supplierTypes="supplierTypes">
                    <template #actions>
                        <PrimaryButton :disabled="formSub && formSub?.processing"  :class="{ 'opacity-10': formSub && formSub?.processing }">
                            Atualizar
                        </PrimaryButton>
                    </template>
                </Form>
            </div>
        </div>
    </AppLayout>
</template>
