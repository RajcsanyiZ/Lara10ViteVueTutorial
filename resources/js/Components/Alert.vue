<script setup>

import { cva } from "class-variance-authority";
import { computed } from 'vue';


/**
 * Requirements:
 * - intent: success, warning, danger, info
 * - icon based on intent: checkmark, triangle, x, info
 * - title & content
 * - dismissable
 */

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    intent: {
        type: String,
        validator(value) {
            return ["info", "success", "warning", "danger"].includes(value)
        },
        default: "info"
    },
    show: {
        type: Boolean,
        default: true
    },
    onDismiss: Function
});

function dismiss() {
    if(props.onDismiss) {
        props.onDismiss();
    }
}

const containerClass = computed(() => {
   return cva("flex p-4 rounded-md space-x-3", {
       variants: {
           intent: {
               info: "bg-blue-100",
               success: "bg-green-100",
               warning: "bg-orange-100",
               danger: "bg-red-100"
           }
       }
   })({
       intent: props.intent
   })
});

const iconClass = computed(() => {
    return cva("w-6 h-6", {
        variants: {
            intent: {
                info: "text-blue-700",
                success: "text-green-700",
                warning: "text-orange-700",
                danger: "text-red-700"
            }
        }
    })({
        intent: props.intent
    })
});

const titleClass = computed(() => {
    return cva("font-medium", {
        variants: {
            intent: {
                info: "text-blue-900",
                success: "text-green-900",
                warning: "text-orange-900",
                danger: "text-red-900"
            }
        }
    })({
        intent: props.intent
    })
});

const contentClass = computed(() => {
    return cva("text-sm", {
        variants: {
            intent: {
                info: "text-blue-800",
                success: "text-green-800",
                warning: "text-orange-800",
                danger: "text-red-800"
            }
        }
    })({
        intent: props.intent
    })
});

const closeButtonClass = computed(() => {
    return cva("p-0.5 rounded-md -m-1", {
        variants: {
            intent: {
                info: "text-blue-900/70 hover:text-blue-900 hover:bg-blue-200",
                success: "text-green-900/70 hover:text-green-900 hover:bg-green-200",
                warning: "text-orange-900/70 hover:text-orange-900 hover:bg-orange-200",
                danger: "text-red-900/70 hover:text-red-900 hover:bg-red-200"
            }
        }
    })({
        intent: props.intent
    })
});


</script>

<template>
    <transition leave-active-class="duration-300 opacity-0" >
        <div v-if="props.show" :class="containerClass">
            <div :class="iconClass">
                <svg v-if="props.intent=='info'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" :class="iconClass">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>

                <svg v-if="props.intent=='success'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" :class="iconClass">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>

                <svg v-if="props.intent=='warning'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" :class="iconClass">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>

                <svg v-if="props.intent=='danger'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" :class="iconClass">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>

            </div>
            <div class="flex-1 space-y-2">
                <h2 :class="titleClass">
                    {{ props.title }}
                </h2>
                <div :class="contentClass">
                    <slot />
                </div>
            </div>
            <div class="shrink-0" v-if="props.onDismiss">
                <button @click="dismiss" :class="closeButtonClass">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </transition>
</template>
