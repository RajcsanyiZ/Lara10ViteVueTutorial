<script setup>

import {computed} from 'vue'

defineProps({
    projects: Array,
    statuses: Object,
    status: String
});

let projectStatusStyles = {
    'waiting':    'border-blue-300 bg-blue-200',
    'inprogress': 'border-orange-300 bg-orange-200',
    'success':    'border-green-300 bg-green-200'
}

let projectTextColors = {
    'waiting':    'text-black',
    'inprogress': 'text-black',
    'success':    'text-gray-400 italic'
}

/**
 * Project status indicator styles
 * @param status
 * @returns {string}
 */
function getProjectStatusStyle(status) {
    return projectStatusStyles.hasOwnProperty(status) ? projectStatusStyles[status] : '';
}

/**
 * Status field css style
 * @param status
 * @returns {string}
 */
function getProjectTextColor(status) {
    return projectTextColors.hasOwnProperty(status) ? projectTextColors[status] : '';
}

</script>


<template>
    <table class="shadow-lg bg-white w-full">
        <tr>
            <th class="bg-blue-100 border text-left px-3 py-2">{{ $t('Project\'s name') }}</th>
            <th class="bg-blue-100 border text-left px-3 py-2">
                {{ $t('Status') }}
            </th>
            <th class="bg-blue-100 border text-left px-3 py-2">{{ $t('Members') }}</th>
            <th class="bg-blue-100 border text-left px-3 py-2">{{ $t('Updated At') }}</th>
        </tr>
        <tr v-for="project in projects"
            :key="project.id"
            class="cursor-pointer odd:bg-gray-50 odd:hover:bg-gray-100 hover:bg-gray-50"
            :class="getProjectTextColor(project.status)">

            <td class="border px-3 py-4">{{ project.name }}</td>

            <td class="border px-3 py-4 w-40">
                <div
                    class="px-3 py-1 border rounded text-center"
                    :class="getProjectStatusStyle(project.status)"
                    >{{ $t(project.status) }}
                </div>
            </td>

            <td class="border px-3 py-4 text-right"
                :class="{'text-gray-300': !project.members}"
                >{{ project.members || '-' }}
            </td>

            <td class="border px-3 py-4 text-right">
                {{ project.updated_at }}
            </td>

        </tr>
    </table>
</template>


