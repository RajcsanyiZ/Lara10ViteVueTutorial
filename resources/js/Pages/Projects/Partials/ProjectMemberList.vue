<script setup>
    import DangerButton from "@/Components/DangerButton.vue"
    import InfoBox from "@/Components/InfoBox.vue";

    defineProps({
        'members': Array
    })

    const emit = defineEmits(['removeMember'])

</script>

<template>
    <div v-if="members.length > 0">
        <table class="w-full">
            <thead>
            <tr>
                <th class="bg-blue-100 border text-left px-3 py-2">Név</th>
                <th class="bg-blue-100 border text-left px-3 py-2">E-mail cím</th>
                <th class="bg-blue-100 border text-left px-3 py-2">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(member, index) in members" :key="member.id">
                <td class="border px-3 py-2">{{ member.name }}</td>
                <td class="border px-3 py-2">{{ member.email }}</td>
                <td class="border px-3 py-2 text-center">
                    <DangerButton @click.prevent="$emit('removeMember', member.id)">x</DangerButton>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <InfoBox v-if="members.length == 0" :title="$t('Members')" >
        {{ $t('No contact has yet been made.') }}
    </InfoBox>

</template>
