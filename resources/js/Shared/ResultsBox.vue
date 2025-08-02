<template>
    <Card class="w-md h-[66vh] overflow-y-auto">
        <!--    Header    -->
        <h2 class="font-bold">Results</h2>
        <HorizontalRule />

        <!--    Body    -->
        <div
            v-if="loading"
            class="flex flex-col text-xs text-gray-300 font-bold justify-center items-center h-full"
        >
            <span>Searching...</span>
        </div>
        <div
            v-else-if="results.length === 0"
            class="flex flex-col text-xs text-gray-300 font-bold justify-center items-center h-full"
        >
            <span>There are zero matches.</span>
            <span>Use the form to search for People or Movies.</span>
        </div>
        <div v-else class="flex flex-col">
            <template v-for="item in results">
                <ResultItem
                    :title="item.name"
                    :type="item.type"
                    :id="item.id"
                />
                <HorizontalRule />
            </template>
        </div>
    </Card>
</template>

<script>

import Card from "../Atoms/Card.vue";
import {defineComponent} from "vue";
import ResultItem from "../Atoms/ResultItem.vue";
import HorizontalRule from "../Atoms/HorizontalRule.vue";

export default defineComponent({
    components: {HorizontalRule, ResultItem, Card},
    props: {
        loading: Boolean,
        results: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {};
    }
})

</script>

<style scoped>

</style>
