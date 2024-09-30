<template>
    <div>{{ formattedPrice }}</div>
</template>

<script setup>
import { computed } from "vue";
const props = defineProps({
    price: [Number, String],
});

const formattedPrice = computed(() => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(props.price);
});
</script>
