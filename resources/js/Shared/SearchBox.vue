<template>
<div class="flex">
    <Card>
        <p class="mb-4 text-xs font-semibold text-[#383838] w-xs">
            What are you searching for?
        </p>

        <!--    Radio buttons    -->
        <div class="flex items-center gap-4 mb-4">
            <label
                v-for="option in searchOptions"
                :key="option.value"
                class="flex items-center gap-1"
            >
                <input
                    type="radio"
                    :name="name"
                    :value="option.value"
                    v-model="selectedType"
                    class="text-blue-600"
                />
                <span class="text-sm font-bold text-black">{{ option.label }}</span>
            </label>
        </div>

        <!--    Search input    -->
        <input
            id="searchInput"
            v-model="searchInput"
            type="text"
            placeholder="e.g. Chewbacca, Yida, Boba Fett"
            class="rounded-md border border-gray-300 px-3 py-2 text-xs shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mb-4"
        />

        <button
            class="rounded-2xl bg-green-600 px-4 py-1 text-xs/4 font-semibold w-full text-white hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed"
            :disabled="searchIsEmpty"
            @click="search"
        >
            SEARCH
        </button>
    </Card>
</div>
</template>

<script>
import Card from "../Atoms/Card.vue";
export default {
    name: "SearchBox",
    components: {Card},
    props: {},
    data() {
        return {
            selectedType: "people",
            searchInput: "",
            searchOptions: [
                {
                    label: "People",
                    value: "people"
                },
                {
                    label: "Movies",
                    value: "movies"
                }
            ]
        }
    },
    methods: {
        search() {
            console.log("Searching...")
        }
    },
    computed: {
        searchIsEmpty() {
            return this.searchInput.length === 0;
        }
    }
}
</script>

<style scoped>

</style>
