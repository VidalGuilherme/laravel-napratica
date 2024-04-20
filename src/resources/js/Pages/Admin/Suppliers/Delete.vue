<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Form from './Partials/Form.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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

const submitForm = (form) => {
    form.delete(route('admin.fornecedores.destroy', props.item.id), {
        errorBag: '',
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Fornecedor - Excluir">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Fornecedor - Excluir
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <div class="mb-10 text-right">
                    <ButtonLink :href="route('admin.fornecedores.edit', item.id)">
                        Editar
                    </ButtonLink>
                    <ButtonLink :href="route('admin.fornecedores.show', item.id)">
                        Visualizar
                    </ButtonLink>
                    <ButtonLink :href="route('admin.fornecedores.create')">
                        Cadastrar
                    </ButtonLink>
                    <ButtonLink :href="route('admin.fornecedores.index')">
                        Listar
                    </ButtonLink>
                </div>

                <Form @submitted="submitForm" :stateIndicators="stateIndicators" :retreats="retreats" :supplierTypes="supplierTypes">
                    <template #actions>
                        <PrimaryButton>
                            Atualizar
                        </PrimaryButton>
                    </template>
                </Form>
            </div>
        </div>
    </AppLayout>
</template>
