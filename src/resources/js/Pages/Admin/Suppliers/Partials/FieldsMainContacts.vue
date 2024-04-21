<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import MaskInput from '@/Components/MaskInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    items: {
        default: [
            {
                id: '',
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
    contactTypes: {
        default: []
    },  
    isDisabled: {
        default: false
    },  
    errors: {
        default: []
    },
});

const addPhone = (index) => {
    console.log(props.items);
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
</script>

<template>    
    <div v-for="n in 1" :key="n" class="grid grid-cols-12 gap-6 col-span-12">
        <div class="col-span-12 lg:col-span-6">
            <InputLabel class="">
                Telefones
            </InputLabel>
            <div v-for="(phone, index) in items[n-1].phones" :key="index" class="grid grid-cols-12 gap-6 col-span-12 mt-4">                
                <div class="ml-2 col-span-5">
                    <InputLabel :for="'phone_'+index">
                        Telefone <span class="text-red-600">*</span>
                    </InputLabel>
                    <MaskInput required
                        :mask="'(##) #####-####'" 
                        :id="'phone_'+index"
                        v-model="phone.phone_number"
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    />                
                    <InputError :message="errors?.cnpj" class="mt-2" />
                </div>

                <div class="col-span-5">
                    <InputLabel :for="'phone_type_'+index">
                        Tipo <span class="text-red-600">*</span>
                    </InputLabel>
                    <SelectInput required
                        :id="'phone_type_'+index"
                        v-model="phone.phone_type"                    
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    >
                        <option value="">Selecione</option>            
                        <option v-for="(option, key) in contactTypes" :key="key" :value="key">{{ option }}</option>        
                    </SelectInput>
                </div>
                <div class="col-span-2 mr-1">
                    <button v-if="index > 0" @click="removePhone(n-1, index)" 
                        type="button" 
                        class="mt-8 px-2 py-1 text-xs float-left font-medium bg-red-700 border border-gray-300 rounded-md font-bold text-white tracking-widest shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-800 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        X
                    </button>
                </div>
            </div>
            <button @click="addPhone(n-1)" 
                type="button" 
                class="mt-4 ml-2 px-2 py-2 text-xs font-medium bg-white border border-gray-300 rounded-md  text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Adicionar
            </button>
        </div>

        <div class="col-span-12 lg:col-span-6">
            <InputLabel class="">
                Emails
            </InputLabel>
            <div v-for="(email, index) in items[n-1].emails" :key="index" class="grid grid-cols-12 gap-6 col-span-12 mt-4">
                <div class="col-span-5 ml-2">
                    <InputLabel :for="'email_'+index">
                        Email <span class="text-red-600">*</span>
                    </InputLabel>
                    <MaskInput required
                        :mask="'(##) #####-####'" 
                        :id="'email_'+index"
                        v-model="email.email"
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    />                
                    <InputError :message="errors?.cnpj" class="mt-2" />
                </div>

                <div class="col-span-5">
                    <InputLabel :for="'email_type_'+index">
                        Tipo <span class="text-red-600">*</span>
                    </InputLabel>
                    <SelectInput required
                        :id="'email_type_'+index"
                        v-model="email.email_type"                    
                        class="block w-full mt-1"
                        :isDisabled="isDisabled"
                    >
                        <option value="">Selecione</option>            
                        <option v-for="(option, key) in contactTypes" :key="key" :value="key">{{ option }}</option>        
                    </SelectInput>        
                </div>
                <div class="col-span-2 mr-1">
                    <button v-if="index > 0" @click="removeEmail(n-1, index)" 
                        type="button" 
                        class="mt-8 px-2 py-1 text-xs float-left font-medium bg-red-700 border border-gray-300 rounded-md font-bold text-white tracking-widest shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-800 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        X
                    </button>
                </div>
            </div>
            <button @click="addEmail(n-1)" 
                type="button" 
                class="mt-4 ml-2 px-2 py-2 text-xs font-medium bg-white border border-gray-300 rounded-md  text-gray-700 tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Adicionar
            </button>
        </div>
    </div>
</template>
