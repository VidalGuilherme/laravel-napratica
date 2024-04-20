<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import FieldsPerson from './FieldsPerson.vue';
import FieldsCompany from './FieldsCompany.vue';
import { ref, watch } from 'vue';
import Accordeon from '@/Components/Accordeon.vue';

const props = defineProps({
    item: {
        default: {
            supplier_type: 'pj',
            cpf: '',
            personal_name: '',
            nickname: '',
            rg: '',
            cnpj: '',
            company_name: '',
            fantasy_name: '',
            state_indicator: '', 
            state_registration: '',            
            municipal_registration: '',            
            cnpj_status: '',            
            retreat: '',
            status: '',
        }
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
    isDisabled: {
        default: false
    },
});

defineEmits(['submitted']);

const supplierType = ref("pj");

const form = useForm({
    supplier: props.item,
});

watch(supplierType, (newType, oldType) => {    
    resetForm(newType);
})

const resetForm = (type) => {
    form.supplier = {
        supplier_type: type,
        cpf: '',
        personal_name: '',
        nickname: '',
        rg: '',
        cnpj: '',
        company_name: '',
        fantasy_name: '',
        state_indicator: '', 
        state_registration: '',            
        municipal_registration: '',            
        cnpj_status: '',            
        retreat: '',
        status: '',
    };
};

</script>

<template>
    <FormSection @submitted="$emit('submitted', form)">
        <template #title>
            Detalhes do Fornecedor
        </template>

        <template #description>
            Criar um novo Fornecedor.
        </template>

        <template #form>
            
            <Accordeon class="col-span-12" :title="'Dados do Fornecedor'" :id="'supplier_data'">
                <div class="grid grid-cols-12 gap-6 col-span-12">
                    <div class="col-span-12">                        
                        <div class="flex items-center">
                            <div v-for="(supType, index) in supplierTypes" :key="index" class="mr-6">
                                <input type="radio"
                                    :id="'supplier_'+index" 
                                    name="supplier_type"
                                    v-model="supplierType" 
                                    :value="index"                                                                                
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                >                        
                                <label :for="'supplier_'+index" class="cursor-pointer ms-2 text-sm text-gray-600">{{ supType }}</label>
                            </div>
                        </div>
                    </div>

                    <FieldsPerson :show="supplierType == 'pf'" :item="form.supplier" :errors="form.errors" :isDisabled="isDisabled"></FieldsPerson>
                    <FieldsCompany :show="supplierType == 'pj'" :item="form.supplier" :stateIndicators="stateIndicators" :retreats="retreats" :errors="form.errors" :isDisabled="isDisabled"></FieldsCompany>

                    <div class="col-span-12 lg:col-span-3">
                        <InputLabel for="status">
                            Ativo <span class="text-red-600">*</span>
                        </InputLabel>
                        <SelectInput required
                            id="status"
                            v-model="form.supplier.status"                    
                            class="block w-full mt-1"
                            :isDisabled="isDisabled"
                        >
                            <option value=""></option>
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </SelectInput>
                        <InputError :message="form.errors?.status" class="mt-2" />
                    </div>
                </div>
            </Accordeon>            

        </template>

        <template #actions>            
            <slot name="actions" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"></slot>
        </template>
    </FormSection>
</template>
