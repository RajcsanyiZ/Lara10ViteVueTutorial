<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectList from './Partials/ProjectList.vue';
import { ref } from 'vue'
import Pagination from "@/Components/Pagination.vue";
import vSelect from "vue-select"
import { Inertia } from '@inertiajs/inertia'
import PrimaryLink from "@/Components/PrimaryLink.vue";

defineProps({
    projects: Object,
    statuses: Object,
    status: String
});

//const status = ref(null)

function changeFilter(event) {
    let status = event.target.value


    Inertia.get('/projects/', { status: status })
}

</script>


<template>
    <!-- $page.props.projects.links[0].active -->
     <!-- {{ $page.props.status }} -->

    <Head :title="$t('Projects')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('Projects') }}
                <span>({{ projects.total }})</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="$page.props.flash.message" class="flex justify-center text-blue-600 mb-4 p-2">
                        {{ $page.props.flash.message }}
                    </div>

                    <div class="p-6 text-gray-900">
                        <div class="text-right mb-4">
                            <div class="flex justify-between">
                                <!-- <x-select :options="statuses"></x-select> -->
                                <label class="font-bold">
                                    Szűrés állapot szerint:
                                    <select @change="changeFilter($event)" :value="status">
                                        <option v-for="(status, index) in statuses" :value="index">{{ status }}</option>
                                    </select>
                                </label>


                                <PrimaryLink
                                    :href="route('projects.create')"
                                    as="button"
                                    >{{ $t('Add new project') }}</PrimaryLink>


                            </div>

                        </div>

                        <ProjectList :projects="projects.data" :statuses="statuses" reduce="" />

                        <div class="mt-6 flex justify-end">
                            <Pagination :links="projects.links" /><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
