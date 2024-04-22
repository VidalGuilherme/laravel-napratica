<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import MaskInput from '@/Components/MaskInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { computed, ref } from 'vue';
import SectionBorder from '@/Components/SectionBorder.vue';

const props = defineProps({
    items: {
        default: [
            {
                id: '',
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
    phoneTypes: {
        default: []
    },
    emailTypes: {
        default: []
    },    
    isDisabled: {
        default: false
    },
    errors: {
        default: []
    },
});

const noContacts = computed(() => {
    return props.items.length <= 1;
});

const addContact = () => {
    props.items.push({
        id: '',
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
    });
};

const removeContact = (index) => {
    props.items.splice(index, 1);
};

const addPhone = (index) => {
    props.items[index].phones.push({
        phone_number: '',
        phone_type: ''
    });
};

const removePhone = (index, n) => {
    props.items[index].phones.splice(n, 1);
};

const addEmail = (index) => {
    props.items[index].emails.push({
        email: '',
        email_type: ''
    });
};

const removeEmail = (index, n) => {
    props.items[index].emails.splice(n, 1);
};

const checkLength = (toCheck) => {    
    return toCheck.trim().length !== 0;
}
</script>

<template>    
    <div>
        <button v-if="!isDisabled" @click="addContact()" 
            type="button" 
            class="mt-1 mr-4 mb-4 ml-2 px-2 py-2 text-xs font-medium bg-white border border-gray-300 rounded-md  text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">
            Adicionar
        </button>
        <span v-show="noContacts">NÃO HÁ CONTATOS ADICIONAIS.</span>
    </div>
    <div v-for="(item, index) in items" :key="index" class="grid grid-cols-12 gap-6 col-span-12">
        
        <div v-if="index > 0" class="col-span-6">
            <InputLabel :for="'contact_name_'+index" class="">
                Nome
            </InputLabel>
            <TextInput
                :id="'contact_name_'+index"
                v-model="item.name"
                type="text"
                class="block w-full mt-1"
                :isDisabled="isDisabled"            
            />
            <InputError :message="errors?.personal_name" class="mt-2" />
        </div>
        <div v-if="index > 0" class="col-span-3">
            <InputLabel :for="'contact_company_'+index" class="">
                Empresa
            </InputLabel>
            <TextInput
                :id="'contact_company_'+index"
                v-model="item.company"
                type="text"
                class="block w-full mt-1"
                :isDisabled="isDisabled"            
            />
            <InputError :message="errors?.personal_name" class="mt-2" />
        </div>
        <div v-if="index > 0" class="col-span-3">
            <InputLabel :for="'contact_office_'+index" class="">
                Empresa
            </InputLabel>
            <TextInput
                :id="'contact_office_'+index"
                v-model="item.office"
                type="text"
                class="block w-full mt-1"
                :isDisabled="isDisabled"            
            />
            <InputError :message="errors?.personal_name" class="mt-2" />
        </div>
        <div v-if="index > 0" class="col-span-12 lg:col-span-6">
            <InputLabel class="">
                Telefones
            </InputLabel>
            <div v-for="(phone, p) in items[index].phones" :key="p" class="grid grid-cols-12 gap-6 col-span-12 mt-4">
                <div class="col-span-5 ml-2">
                    <InputLabel :for="'phone_'+p">
                        Telefone <span v-show="checkLength(phone.phone_number) || checkLength(phone.phone_type)" class="text-red-600">*</span>
                    </InputLabel>
                    <MaskInput :required="checkLength(phone.phone_number) || checkLength(phone.phone_type)"
                        :mask="'(##) #####-####'" 
                        :id="'phone_'+p"
                        v-model="phone.phone_number"
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    />                
                    <InputError :message="errors?.cnpj" class="mt-2" />
                </div>

                <div class="col-span-5">
                    <InputLabel :for="'phone_type_'+p">
                        Tipo <span v-show="checkLength(phone.phone_number) || checkLength(phone.phone_type)" class="text-red-600">*</span>
                    </InputLabel>
                    <SelectInput :required="checkLength(phone.phone_number) || checkLength(phone.phone_type)"
                        :id="'phone_type_'+p"
                        v-model="phone.phone_type"                    
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    >
                        <option value="">Selecione</option>            
                        <option v-for="(option, key) in phoneTypes" :key="key" :value="key">{{ option }}</option>        
                    </SelectInput>        
                </div>
                <div class="col-span-2 mr-1">
                    <button v-if="p > 0 && !isDisabled" @click="removePhone(index, p)" 
                        type="button" 
                        class="mt-8 px-2 py-1 text-xs float-left font-medium bg-red-700 border border-gray-300 rounded-md font-bold text-white tracking-widest shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-800 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        X
                    </button>
                </div>
            </div>
            <button v-if="!isDisabled" @click="addPhone(index)" 
                type="button" 
                class="mt-4 ml-2 px-2 py-2 text-xs font-medium bg-white border border-gray-300 rounded-md  text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Adicionar
            </button>
        </div>

        <div v-if="index > 0" class="col-span-12 lg:col-span-6">
            <InputLabel class="">
                Emails
            </InputLabel>
            <div v-for="(email, e) in items[index].emails" :key="e" class="grid grid-cols-12 gap-6 col-span-12 mt-4">
                <div class="col-span-5 ml-2">
                    <InputLabel :for="'email_'+e">
                        Email <span v-show="checkLength(email.email) || checkLength(email.email_type)" class="text-red-600">*</span>
                    </InputLabel>
                    <TextInput :required="checkLength(email.email) || checkLength(email.email_type)"
                        :id="'email_'+index"
                        type="email"
                        v-model="email.email"
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    />
                    <InputError :message="errors?.cnpj" class="mt-2" />
                </div>

                <div class="col-span-5">
                    <InputLabel :for="'email_type_'+e">
                        Tipo <span v-show="checkLength(email.email) || checkLength(email.email_type)" class="text-red-600">*</span>
                    </InputLabel>
                    <SelectInput :required="checkLength(email.email) || checkLength(email.email_type)"
                        :id="'email_type_'+e"
                        v-model="email.email_type"                    
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    >
                        <option value="">Selecione</option>            
                        <option v-for="(option, key) in emailTypes" :key="key" :value="key">{{ option }}</option>        
                    </SelectInput>        
                </div>
                <div class="col-span-2 mr-1">
                    <button v-if="e > 0 && !isDisabled" @click="removeEmail(index, e)" 
                        type="button" 
                        class="mt-8 px-2 py-1 text-xs float-left font-medium bg-red-700 border border-gray-300 rounded-md font-bold text-white tracking-widest shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-800 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        X
                    </button>
                </div>
            </div>
            <button v-if="!isDisabled" @click="addEmail(index)" 
                type="button" 
                class="mt-4 ml-2 px-2 py-2 text-xs font-medium bg-white border border-gray-300 rounded-md  text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Adicionar
            </button>
        </div>
        <div v-if="index > 0" class="col-span-10" :class="{'col-span-12' : isDisabled}">
            <SectionBorder></SectionBorder>        
        </div>
        <div v-if="index > 0" class="col-span-2">            
            <button v-if="!isDisabled" @click="removeContact(index)" 
                type="button" 
                class="mt-4 ml-2 px-2 py-2 text-xs font-medium bg-red-700 border border-gray-300 rounded-md font-bold text-white tracking-widest shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-800 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Remover
            </button>
        </div>
    </div>    
</template>
