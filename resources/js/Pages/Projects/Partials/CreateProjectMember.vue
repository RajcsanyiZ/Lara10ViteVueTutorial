<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";
import {computed, reactive } from "vue";
import { useVuelidate } from '@vuelidate/core';
import { required, email, helpers } from '@vuelidate/validators';

const props = defineProps({
    reset: {
        type: Boolean,
        default: false
    },
    members: Array
})

let formData = reactive({
    name: "x",
    email: "jozsi@zala"
});

let errors = reactive({
    name: false,
    email: false
});

const emails = computed(() => {
    return props.members.map(member => member.email);
});


const uniqueEmail = (value) => !emails.value.includes(value);

const rules = {
    name: { required },
    email: {
        required,
        email,
        uniqueEmail: helpers.withMessage('This email is already in use.', uniqueEmail),
    }
}

const v = useVuelidate(rules, formData, {scope: false});

const emit = defineEmits(['addNewContact'])

function simplifyValidators() {
    errors.name = v.value.name.$error ? v.value.name.$errors[0].$message : false;
    errors.email = v.value.email.$error ? v.value.email.$errors[0].$message : false;
}

function addNewContact() {
    v.value.$validate();

    simplifyValidators();

    if (!v.value.$error) {
        emit('addNewContact', formData);
        v.value.$reset();
        formData.name = '';
        formData.email = '';
    }

}

</script>


<template>
    <form>
        <!--
        <div class="bg-red-100 h-8 text-red-700">
            <p v-for="error of v.$errors" :key="error.$uid">
                {{ error.$message }}
            </p>
        </div>
        -->

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="subform_member_name"
            >Név</label>

            <input
                v-model="formData.name"
                id="subform_member_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder-gray-400"
                :class="{ 'border-red-500': errors.name, 'border-gray-400': !errors.name }"
                type="text"
                :placeholder="$t('name')"
                required
            >

            <p v-if="errors.name" class="text-red-500 text-xs italic">{{ $t(errors.name) }}</p>

        </div>
        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                   for="subform_member_email"
            >E-mail cím</label>

            <input
                v-model="formData.email"
                id="subform_member_email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder-gray-400"
                :class="{ 'border-red-500': errors.email, 'border-gray-400': !errors.email }"
                type="email"
                :placeholder="$t('email address')"
                required
            >

            <p v-if="errors.email" class="text-red-500 text-xs italic">{{ $t(errors.email) }}</p>

        </div>
        <div class="mb-6 text-right">
            <PrimaryButton @click.prevent="addNewContact">
                {{ $t('Add project member')}}
            </PrimaryButton>
        </div>
    </form>
</template>
