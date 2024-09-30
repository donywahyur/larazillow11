<template>
    <form @submit.prevent="filter">
        <div class="mb-8 ,t-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center">
                <input
                    type="text"
                    placeholder="Price from"
                    class="input-filter-l w-28"
                    v-model="form.priceFrom"
                />
                <input
                    type="text"
                    placeholder="Price to"
                    class="input-filter-r w-28"
                    v-model="form.priceTo"
                />
            </div>
            <div class="flex flex-nowrap items-center">
                <select class="input-filter-l w-28" v-model="form.beds">
                    <option :value="null">Beds</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>
                <select class="input-filter-r w-28" v-model="form.baths">
                    <option :value="null">Baths</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>
            </div>
            <div class="flex flex-nowrap items-center">
                <input
                    type="text"
                    placeholder="Area from"
                    class="input-filter-l w-28"
                    v-model="form.areaFrom"
                />
                <input
                    type="text"
                    placeholder="Area to"
                    class="input-filter-r w-28"
                    v-model="form.areaTo"
                />
            </div>
            <button type="submit" class="btn-normal">Filter</button>
            <button type="reset" @click="clear">Clear</button>
        </div>
    </form>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    filters: Object,
});

const form = useForm({
    priceFrom: props.filters.priceFrom ?? null,
    priceTo: props.filters.priceTo ?? null,
    areaFrom: props.filters.areaFrom ?? null,
    areaTo: props.filters.areaTo ?? null,
    beds: props.filters.beds ?? null,
    baths: props.filters.baths ?? null,
});

const filter = () => {
    form.get(route("listing.index"), {
        preserveState: true,
        preserveScroll: true,
    });
};

const clear = () => {
    form.priceFrom = null;
    form.priceTo = null;
    form.areaFrom = null;
    form.areaTo = null;
    form.beds = null;
    form.baths = null;
};
</script>
