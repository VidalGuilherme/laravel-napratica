<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import MaskInput from '@/Components/MaskInput.vue';

const props = defineProps({
    item: {
        default: {
            cpf: '',
            personal_name: '',
            nickname: '',
            rg: '',            
        }
    },
    isDisabled: {
        default: false
    },
    errors: {
        default: []
    },
    show: {
        default: true,
    },
});

</script>

<template>    

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="cpf">
            CPF <span class="text-red-600">*</span>
        </InputLabel>
        <MaskInput :required="show"
            :mask="'###.###.###-##'" 
            id="cpf"
            v-model="item.cpf"
            class="block w-full mt-1"
            :isDisabled="isDisabled"
        />                
        <InputError :message="errors?.cpf" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-6">
        <InputLabel for="personal_name">
            Nome <span class="text-red-600">*</span>
        </InputLabel>
        <TextInput :required="show"
            id="personal_name"
            v-model="item.personal_name"
            type="text"
            class="block w-full mt-1"
            :isDisabled="isDisabled"            
        />
        <InputError :message="errors?.personal_name" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="nickname" value="Apelido" />
        <TextInput
            id="nickname"
            v-model="item.nickname"
            class="block w-full mt-1"
            :isDisabled="isDisabled"
        />                
        <InputError :message="errors?.nickname" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="rg">
            RG <span class="text-red-600">*</span>
        </InputLabel>
        <TextInput :required="show"
            id="rg"
            v-model="item.rg"            
            class="block w-full mt-1"
            :isDisabled="isDisabled"
        />
        <InputError :message="errors?.rg" class="mt-2" />
    </div>
            
</template>
