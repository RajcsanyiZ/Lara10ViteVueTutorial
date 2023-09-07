<template>
    <div>
        <Link
            is="link.url==null?'span':'Link'"
            v-for="link in links"
            :href="link.url"
            v-html="$t(link.label)"
            class="px-1"
            :class="{'text-gray-500':link.url==null, 'font-bold':link.active }"
        />
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3';

    defineProps({
        links: "Array"
    })
</script>




