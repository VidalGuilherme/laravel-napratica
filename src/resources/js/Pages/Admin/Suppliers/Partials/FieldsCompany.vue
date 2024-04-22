<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import MaskInput from '@/Components/MaskInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { computed } from 'vue';

const props = defineProps({
    item: {
        default: {
            cnpj: '',
            company_name: '',
            fantasy_name: '',
            state_indicator: '', 
            state_registration: '',            
            municipal_registration: '',            
            cnpj_status: '',            
            retreat: '',
        }
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
    errors: {
        default: []
    },
    show: {
        default: true,
    },
});

const emit = defineEmits(['changeStateIndicator', 'changeCnpj']);

const checkStateIndicator = computed(() => {
    return props.item.state_indicator == '' || props.item.state_indicator == 'nao_contribuinte';
});

const changeCnpj = async () => {    
    if(props.item.cnpj.length < 18) return;

    const cnpj = props.item.cnpj.replace(/[^0-9]/g, '');    
    try {
        const { data } = await axios.get(route('admin.suppliers.json.cnpj'),  {
            params: { cnpj: cnpj}
        });
        if(data.status == "OK"){
            emit('changeCnpj', data);
        }
    } catch (error) {
        console.error(error);
    }

};

</script>

<template>    

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="cnpj">
            CNPJ <span class="text-red-600">*</span>
        </InputLabel>
        <MaskInput :required="show"
            :mask="'##.###.###/####-##'" 
            id="cnpj"
            v-model="item.cnpj"
            class="block w-full mt-1"
            :isDisabled="isDisabled"
            @keyup="changeCnpj"
        />                
        <InputError :message="errors?.cnpj" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-6">
        <InputLabel for="company_name">
            Razão Social <span class="text-red-600">*</span>
        </InputLabel>
        <TextInput :required="show"
            id="company_name"
            v-model="item.company_name"
            type="text"
            class="block w-full mt-1"
            :isDisabled="isDisabled"            
        />
        <InputError :message="errors?.company_name" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="fantasy_name">
            Nome Fantasia <span class="text-red-600">*</span>
        </InputLabel>
        <TextInput
            id="fantasy_name"
            v-model="item.fantasy_name"
            class="block w-full mt-1"
            :isDisabled="isDisabled"
        />                
        <InputError :message="errors?.fantasy_name" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="state_indicator">
            Indicador de Inscrição Estadual <span class="text-red-600">*</span>
        </InputLabel>
        <SelectInput :required="show"
            id="state_indicator"
            v-model="item.state_indicator"                    
            class="block w-full mt-1"
            :isDisabled="isDisabled"
            @change="$emit('changeStateIndicator', item.state_indicator)"
        >
            <option value="">Selecione</option>            
            <option v-for="(indicator, index) in stateIndicators" :key="index" :value="index">{{ indicator }}</option>        
        </SelectInput>
        <InputError :message="errors?.state_indicator" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="state_registration">
            Inscrição Estadual <span v-show="!checkStateIndicator" class="text-red-600">*</span>
        </InputLabel>
        <TextInput :required="show"
            id="state_registration"
            v-model="item.state_registration"            
            class="block w-full mt-1"
            :isDisabled="isDisabled || checkStateIndicator"
        />
        <InputError :message="errors?.state_registration" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="municipal_registration">
            Inscrição Municipal <span class="text-red-600">*</span>
        </InputLabel>
        <TextInput :required="show"
            id="municipal_registration"
            v-model="item.municipal_registration"            
            class="block w-full mt-1"
            :isDisabled="isDisabled"
        />
        <InputError :message="errors?.municipal_registration" class="mt-2" />
    </div>

    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="cnpj_status">
            Situação CNPJ
        </InputLabel>
        <TextInput
            id="cnpj_status"
            v-model="item.cnpj_status"            
            class="block w-full mt-1"
            :isDisabled="true"
        />
        <InputError :message="errors?.cnpj_status" class="mt-2" />
    </div>
            
    <div v-show="show" class="col-span-12 lg:col-span-3">
        <InputLabel for="retreat">
            Recolhimento <span class="text-red-600">*</span>
        </InputLabel>
        <SelectInput :required="show"
            id="retreat"
            v-model="item.retreat"                    
            class="block w-full mt-1"
            :isDisabled="isDisabled"
        >
            <option value="">Selecione</option>            
            <option v-for="(option, index) in retreats" :key="index" :value="index">{{ option }}</option>        
        </SelectInput>
        <InputError :message="errors?.retreat" class="mt-2" />
    </div>
</template>
