<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ToastList from '@/Components/ToastList.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import toast from '@/Stores/toast';
import Alert from '@/Components/Alert.vue';
import {ref} from 'vue';

/*
const form = useForm({});

function submit(e) {
    form.post('/test')
}
*/

function addToast() {
    toast.add({
        message: 'valami új...',
        duration: 10000
    });
}

const showAlert = ref(true);



</script>

<template>
    <Head :title="$t('Dashboard')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Dashboard')}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 space-y-4">

                        <!--<div>
                            <form @submit.prevent="submit">
                                <PrimaryButton>Submit</PrimaryButton>
                            </form>
                        </div>

                        <div>
                            <PrimaryButton @click="addToast">
                                Add toast
                            </PrimaryButton>
                        </div>-->


                        <Alert :show="showAlert" :on-dismiss="() => (showAlert = false)" title="Title"  intent="info">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda blanditiis corporis cupiditate delectus eum exercitationem illum, ipsam nam nisi non omnis perspiciatis quaerat quasi quibusdam similique ullam voluptas voluptatum!</p>
                        </Alert>

                        <Alert :show="showAlert" :on-dismiss="() => (showAlert = false)" title="Ez egy üzenet" intent="danger">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda blanditiis corporis cupiditate delectus eum exercitationem illum, ipsam nam nisi non omnis perspiciatis quaerat quasi quibusdam similique ullam voluptas voluptatum!</p>
                        </Alert>

                        <PrimaryButton @click="addToast">
                            Add toast
                        </PrimaryButton>

                        <div>
                            {{ $t('You\'re logged in!') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
