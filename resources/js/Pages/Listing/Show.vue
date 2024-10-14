<template>
    <div class="flex flex-col-reverse md:grid grid-cols-12 gap-4">
        <Box
            v-if="listing.images.length"
            class="md:col-span-7 flex items-center w-full"
        >
            <div class="grid grid-cols-2 gap-4">
                <img
                    v-for="image in listing.images"
                    :key="image.id"
                    :src="image.src"
                />
            </div>
        </Box>
        <EmptyState v-else class="md:col-span-7 flex items-center">
            No Images
        </EmptyState>
        <div class="md:col-span-5 flex flex-col gap-4">
            <Box>
                <template #header>Basic Info</template>
                <Price :price="listing.price" class="text-2xl font-bold" />
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-500"
            /></Box>
            <Box>
                <template #header>Monthly Payment</template>
                <label class="label">Interest Rate ({{ interestRate }}%)</label>
                <input
                    v-model.number="interestRate"
                    class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                    type="range"
                    min="0.1"
                    max="30"
                    step="0.1"
                />

                <label class="label">Duration ({{ duration }} years)</label>
                <input
                    v-model.number="duration"
                    class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                    type="range"
                    min="3"
                    max="35"
                    step="1"
                />

                <div class="text-grey-600 dark:text-grey-300 mt-2">
                    <div class="text-grey-400">Your Monthly payment</div>
                    <Price :price="monthlyPayment" class="text-3xl" />
                    <div class="mt-2 text-gray-500">
                        <div class="flex justify-between">
                            <div>Total paid</div>
                            <Price :price="totalPaid" class="font-medium" />
                        </div>
                        <div class="flex justify-between">
                            <div>Principal paid</div>
                            <Price :price="listing.price" class="font-medium" />
                        </div>
                        <div class="flex justify-between">
                            <div>Total Interest</div>
                            <Price :price="totalInterest" class="font-medium" />
                        </div>
                    </div>
                </div>
            </Box>
            <MakeOffer
                v-if="user && !offerMade"
                @offerUpdated="offer = $event"
                :listingId="listing.id"
                :price="listing.price"
            />

            <OfferMade v-if="user && offerMade" :offer="offerMade" />
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import MakeOffer from "@/Pages/Listing/Show/Components/MakeOffer.vue";
import OfferMade from "@/Pages/Listing/Show/Components/OfferMade.vue";
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";

import { ref, computed } from "vue";
import { useMonthlyPayment } from "@/Composables/useMonthlyPayment";
import EmptyState from "@/Components/UI/EmptyState.vue";

const interestRate = ref(2.5);
const duration = ref(25);

const props = defineProps({
    listing: Object,
    offerMade: Object,
});

const offer = ref(props.listing.price);

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
    offer,
    interestRate,
    duration
);

const page = usePage();
const user = computed(() => page.props.user);
</script>
