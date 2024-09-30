<template>
    <form>
        <div class="mb-4 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    v-model="filterForm.deleted"
                    id="deleted"
                    type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="deleted">Deleted</label>
            </div>

            <div>
                <select class="input-filter-l w-24" v-model="filterForm.by">
                    <option value="created_at">Added</option>
                    <option value="price">Price</option>
                </select>
                <select class="input-filter-r w-32" v-model="filterForm.order">
                    <option
                        v-for="option in sortOptions"
                        :key="option.value"
                        :value="option.value"
                    >
                        {{ option.label }}
                    </option>
                </select>
            </div>
        </div>
    </form>
</template>

<script setup>
import { reactive, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";

const props = defineProps({
    filters: Object,
});

const sortLabels = {
    created_at: [
        {
            label: "Latest",
            value: "desc",
        },
        {
            label: "Oldest",
            value: "asc",
        },
    ],
    price: [
        {
            label: "Pricey",
            value: "desc",
        },
        {
            label: "Cheapest",
            value: "asc",
        },
    ],
};

const sortOptions = computed(() => {
    return sortLabels[filterForm.by];
});

const filterForm = reactive({
    drafts: props.filters.drafts ?? false,
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? "created_at",
    order: props.filters.order ?? "desc",
});

watch(
    filterForm,
    debounce(
        () =>
            router.get(route("realtor.listing.index"), filterForm, {
                replace: true,
                preserveState: true,
            }),
        1000
    )
);
</script>
