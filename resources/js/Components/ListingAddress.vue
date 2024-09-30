<template>
    {{ listing.street }} {{ listing.street_nr }}, {{ listing.city }}
</template>
<script setup>
defineProps({
    listing: Object,
});
</script>
