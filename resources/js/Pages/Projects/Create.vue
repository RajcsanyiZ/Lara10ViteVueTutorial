<script setup>
import PrimaryLink from "@/Components/PrimaryLink.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

import { reactive, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useVuelidate } from '@vuelidate/core';
import { required } from '@vuelidate/validators';

import CreateProjectMember from "./Partials/CreateProjectMember.vue";
import ProjectMemberList from "./Partials/ProjectMemberList.vue";

const props = defineProps({
    project: Object,
    statuses: Array,
    errors: Object
})

let form = reactive({
    name: props.project.name,
    note: '',
    status: 'WAITING',
    members: [
        {id: 1, name: "Józsi", email: "jozsi@zala.hu"},
        {id: 2, name: "Sanyi", email: "sanysz@veszprem.hu"}
    ]
});

let errors = reactive({
    name: false,
    note: false
});

const rules = {
    name: { required },
    note: { required, min:3, max:30 }
}

const v = useVuelidate(rules, form, {$scope: false});

function simplifyValidators() {
    errors.name = v.value.name.$error ? v.value.name.$errors[0].$message : false;
    errors.note = v.value.note.$error ? v.value.note.$errors[0].$message : false;
}

const addNewContact = (subform) =>  {
    form.members.push({
        id: Math.random(),
        name: subform.name,
        email: subform.email
    });
}

function submit() {
    v.value.$validate();
    simplifyValidators();

    if (!v.value.$error) {
        Inertia.post('/projects', form);
        console.log('Ok!');
    } else {
        console.log('Hiba!')
    }
}

function addProjectMember(member) {
    console.log(member);
}

function removeMember(id){
    form.members = form.members.filter(member => member.id!== id);
}


</script>

<template>
    <BaseLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div>{{ $t('Create New Project') }}</div>
                <PrimaryLink :href="route('projects.index')">
                    {{ $t('Go Back')}}
                </PrimaryLink>
            </div>
        </template>

        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl mb-3">
                    Projekt alapadatai
                </h2>
                <form @submit.prevent="submit" class="max-w-md">
                    <div class="mb-6">
                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                               for="name"
                        >
                            {{ $t('name') }}
                        </label>

                        <input
                            v-model="form.name"
                            class="border border-gray-400 p-2 w-full"
                            :class="{ 'border-red-500': errors.name, 'border-gray-400': !errors.name }"
                            type="text"
                            name="name"
                            id="name">

                        <p v-if="errors.name" class="text-red-500 text-xs italic">{{ $t(errors.name) }}</p>
                    </div>

                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                           for="status"
                    >{{ $t('status') }}

                        <select v-model="form.status"
                                class="border border-gray-400 p-2 w-full"
                                name="status"
                                id="status"
                                required
                        >
                            <option v-for="(status, index) in statuses" :value="index">{{ status }}</option>
                        </select>
                    </label>



                    <div class="mb-6">
                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                               for="note"
                        >
                            {{ $t('note') }}
                        </label>

                        <textarea
                            v-model="form.note"
                            class="border border-gray-400 p-2 w-full"
                            :class="{ 'border-red-500': errors.note, 'border-gray-400': !errors.note }"
                            rows="10"
                            type="text"
                            name="note"
                            id="note"
                        ></textarea>
                        <p v-if="errors.note" class="text-red-500 text-xs italic">{{ $t(errors.note) }}</p>

                    </div>

                    <div class="mb-6 text-right">
                        <PrimaryButton @click.prevent="submit">
                            {{ $t('Submit') }}
                        </PrimaryButton>

                    </div>
                </form>
            </div>
            <div class="w-full">
                <h2 class="text-xl mb-3">
                    Kapcsolattartó(k)
                </h2>

                <CreateProjectMember @addNewContact="addNewContact" :members="form.members" />

                <ProjectMemberList @removeMember="removeMember" :members="form.members" />

            </div>
        </div>
    </BaseLayout>
</template>

