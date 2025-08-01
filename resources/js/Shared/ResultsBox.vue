<template>
<div class="flex">
    <Card class="w-md h-[66vh]">
        <!--    Header    -->
        <h2 class="font-bold">Results</h2>
        <div class="border-b border-gray-200 w-full my-1"></div>

        <!--    Body    -->
        <div
            v-if="results.length === 0"
            class="flex flex-col text-xs text-gray-300 font-bold justify-center items-center h-full"
        >
            <span>There are zero matches.</span>
            <span>Use the form to search for People or Movies.</span>
        </div>
    </Card>
</div>
</template>

<script>

import Card from "../Atoms/Card.vue";
import {defineComponent} from "vue";

export default defineComponent({
    components: {Card},
    props: {},
    data() {
        return {
            results: [],
        };
    }
})

</script>

<style scoped>

</style>
