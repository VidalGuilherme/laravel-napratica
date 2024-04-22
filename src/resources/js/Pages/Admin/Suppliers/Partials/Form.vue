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
import FieldsAddress from './FieldsAddress.vue';
import FieldsMainContacts from './FieldsMainContacts.vue';
import FieldsAdditionalContacts from './FieldsAdditionalContacts.vue';

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
            active: '',
        }
    },
    addresses: {
        default: [
            {
                supplier_id: '',
                zipcode: '',
                street: '',
                number: '', 
                complement: '',            
                district: '',     
                reference_point: '',
                city_id: '',
                condominium: '',
                state: null,
            }
        ],
    },
    contacts: {
        default: [
            {
                id: '',
                order: 1,
                name: '',
                company: '',
                office: '',
                phones: [
                    {
                        phone_number: '',
                        phone_type: ''
                    }
                ],
                emails: [
                    {
                        email: '',
                        email_type: ''
                    }
                ]
            }
        ]
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
    isDisabled: {
        default: false
    },
});

defineEmits(['submitted']);

const form = useForm({
    supplier: props.item,
    addresses: props.addresses,
    contacts: props.contacts,
});

const supplierType = ref(props.item.supplier_type);
watch(supplierType, (newType, oldType) => {    
    if(!props.isDisabled) resetForm(newType);
});

const changeStateIndicator = (state_indicator) => {
    if(state_indicator == '' || state_indicator == 'nao_contribuinte'){
        form.supplier.state_registration = '';
    }
};

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
        active: '',
    };
};

</script>

<template>
    <FormSection @submitted="$emit('submitted', form)">
        
        <template #form>
            
            <Accordeon class="col-span-12" title="Dados do Fornecedor" :id="'supplier_data'">
                <div class="grid grid-cols-12 gap-6 col-span-12">
                    <div class="col-span-12">                        
                        <div class="flex items-center">
                            <div v-for="(supType, index) in supplierTypes" :key="index" class="mr-6">
                                <input type="radio"
                                    :id="'supplier_'+index" 
                                    name="supplier_type"
                                    v-model="supplierType" 
                                    :value="index"      
                                    :disabled="isDisabled || form.supplier.id"                                                                          
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    :class="isDisabled || form.supplier.id ? 'disabled:opacity-75 dark:bg-gray-500 bg-gray-200' : ''"
                                >                        
                                <label :for="'supplier_'+index" class="cursor-pointer ms-2 text-sm text-gray-600">{{ supType }}</label>
                            </div>
                        </div>
                    </div>

                    <FieldsPerson :show="supplierType == 'pf'" :item="form.supplier" :errors="form.errors" :isDisabled="isDisabled"></FieldsPerson>
                    <FieldsCompany 
                        :show="supplierType == 'pj'" 
                        :item="form.supplier" :stateIndicators="stateIndicators" :retreats="retreats" :errors="form.errors" 
                        :isDisabled="isDisabled"
                        @changeStateIndicator="changeStateIndicator">
                    </FieldsCompany>

                    <div class="col-span-12 lg:col-span-3">
                        <InputLabel for="active">
                            Ativo <span class="text-red-600">*</span>
                        </InputLabel>
                        <SelectInput required
                            id="active"
                            v-model="form.supplier.active"
                            class="block w-full mt-1"
                            :isDisabled="isDisabled"
                        >
                            <option value=""></option>
                            <option :value="false">Não</option>
                            <option :value="true">Sim</option>
                        </SelectInput>
                        <InputError :message="form.errors?.active" class="mt-2" />
                    </div>
                </div>
            </Accordeon>
            
            <Accordeon class="col-span-12" title="Contato Principal" :id="'supplier_data'">
                <FieldsMainContacts :items="form.contacts" :phoneTypes="phoneTypes" :emailTypes="emailTypes" :errors="form.errors" :isDisabled="isDisabled"></FieldsMainContacts>
            </Accordeon>

            <Accordeon class="col-span-12" title="Contatos Adicionais" :id="'supplier_data'">
                <FieldsAdditionalContacts :items="form.contacts" :phoneTypes="phoneTypes" :emailTypes="emailTypes" :errors="form.errors" :isDisabled="isDisabled"></FieldsAdditionalContacts>
            </Accordeon>

            <Accordeon class="col-span-12" title="Dados de Endereço" :id="'supplier_data'">
                <FieldsAddress :items="form.addresses" :states="states" :cities="cities" :errors="form.errors" :isDisabled="isDisabled"></FieldsAddress>                
            </Accordeon>

            <Accordeon class="col-span-12" title="Observação" :id="'supplier_data'">
                <div class="grid grid-cols-12 gap-6 col-span-12">
                    <div class="col-span-12">

                        <InputError :message="form.errors?.active" class="mt-2" />
                    </div>
                </div>
            </Accordeon>

        </template>

        <template #actions>            
            <slot name="actions" :class="{ 'opacity-10': form.processing }" :disabled="form.processing"></slot>
        </template>
    </FormSection>
</template>
