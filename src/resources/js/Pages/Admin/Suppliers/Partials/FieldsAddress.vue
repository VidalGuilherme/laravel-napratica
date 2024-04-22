<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import MaskInput from '@/Components/MaskInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref } from 'vue';

const props = defineProps({
    items: {
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
        ]
    },
    states: {
        default: []
    },
    cities: {
        default: []
    },
    isDisabled: {
        default: false
    },
    errors: {
        default: []
    },
});

const stateSelected = ref({
    selected: props.items[0]?.city?.state_id,
    changing: false,
});
const cities = ref(props.cities);

const changeState = async () => {

    if(!stateSelected.value) return;
    stateSelected.value.changing = true;
    try {
        const response = await axios.get(route('admin.cities.json.list'),  {
            params: { state_id: stateSelected.value.selected}
        });
        cities.value = response.data;
    } catch (error) {
        console.error("Error fetching file preview log data:", error);
    }
    stateSelected.value.changing = false;   
}

</script>

<template>    
    <div v-for="(item, index) in items" :key="index" class="grid grid-cols-12 gap-6 col-span-12">
        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="zipcode">
                CEP <span class="text-red-600">*</span>
            </InputLabel>
            <MaskInput
                :mask="'#####-##'" 
                id="zipcode"
                v-model="item.zipcode"
                class="block w-full mt-1"
                :isDisabled="isDisabled"
            />                
            <InputError :message="errors[`addresses.${index}.zipcode`]" class="mt-2" />
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="street">
                Logradouro <span class="text-red-600">*</span>
            </InputLabel>
            <TextInput required
                id="street"
                v-model="item.street"
                type="text"
                class="block w-full mt-1"
                :isDisabled="isDisabled"            
            />
            <InputError :message="errors[`addresses.${index}.street`]" class="mt-2" />
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="number">
                Número <span class="text-red-600">*</span>
            </InputLabel>
            <TextInput required
                id="number"
                v-model="item.number"
                class="block w-full mt-1"
                :isDisabled="isDisabled"
            />                
            <InputError :message="errors[`addresses.${index}.number`]" class="mt-2" />
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="complement">
                Complemento
            </InputLabel>
            <TextInput
                id="complement"
                v-model="item.complement"            
                class="block w-full mt-1"
                :isDisabled="isDisabled"
            />
            <InputError :message="errors[`addresses.${index}.complement`]" class="mt-2" />
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="district">
                Bairro <span class="text-red-600">*</span>
            </InputLabel>
            <TextInput required
                id="district"
                v-model="item.district"            
                class="block w-full mt-1"
                :isDisabled="isDisabled"
            />
            <InputError :message="errors[`addresses.${index}.district`]" class="mt-2" />
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="reference_point">
                Ponto de Referência
            </InputLabel>
            <TextInput
                id="reference_point"
                v-model="item.reference_point"            
                class="block w-full mt-1"
                :isDisabled="isDisabled"
            />
            <InputError :message="errors[`addresses.${index}.reference_point`]" class="mt-2" />
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="state">
                UF <span class="text-red-600">*</span>
            </InputLabel>
            <SelectInput required
                id="state"
                v-model="stateSelected.selected"                    
                class="block w-full mt-1"
                :isDisabled="isDisabled"
                @change="changeState"
            >
                <option value="">Selecione</option>            
                <option v-for="(state, index) in states" :key="state.id" :value="state.id">{{ state.uf }}</option>        
            </SelectInput>        
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="city_id">
                Cidade <span class="text-red-600">*</span>
            </InputLabel>
            <SelectInput required
                id="city_id"
                v-model="item.city_id"                    
                class="block w-full mt-1"
                :isDisabled="isDisabled || stateSelected.changing"
            >
                <option value="">Selecione</option>            
                <option v-for="(city, index) in cities" :key="city.id" :value="city.id">{{ city.name }}</option>        
            </SelectInput>
            <InputError :message="errors[`addresses.${index}.city_id`]" class="mt-2" />     
        </div>

        <div class="col-span-12 lg:col-span-3">
            <InputLabel for="condominium">
                Condomínio <span class="text-red-600">*</span>
            </InputLabel>
            <SelectInput required
                id="condominium"
                v-model="item.condominium"
                class="block w-full mt-1"
                :isDisabled="isDisabled"
            >
                <option value=""></option>
                <option :value="false">Não</option>
                <option :value="true">Sim</option>
            </SelectInput>
            <InputError :message="errors[`addresses.${index}.condominium`]" class="mt-2" />
        </div>
    </div>
</template>
