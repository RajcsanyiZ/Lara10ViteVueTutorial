<script setup>
    import ToastListItem from "./ToastListItem.vue";
    import {ref, onUnmounted} from "vue"
    import {Inertia} from "@inertiajs/inertia";
    import {usePage} from "@inertiajs/inertia-vue3";
    import toast from "@/Stores/toast";

    const page = usePage()

    let removeFinishEventListener = Inertia.on('finish', () => {
        if (page.props.value.toast) {
            toast.add({
                message: page.props.value.toast
            })
        }
    });

    onUnmounted(() => removeFinishEventListener());

    function remove(index) {
        toast.remove(index);
    }
</script>

<template>
    <TransitionGroup
        tag="div"
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-500 "
        leave-to-class="duration-500 "
        leave-active-class="translate-x-full opacity-0"
        class="fixed top-4 right-4 z-50 space-y-4 w-full max-w-xs">
        <toast-list-item
            v-for="(item, index) in toast.items"
            :key="item.key"
            :index="index"
            :message="item.message"
            :duration="druation"
            @remove="remove(index)"/>
    </TransitionGroup>
</template>
