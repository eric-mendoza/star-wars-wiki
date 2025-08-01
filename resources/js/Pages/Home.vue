<template>
    <div class="flex justify-center gap-4 p-4">
        <SearchBox
            v-model:loading="loading"
            v-model:results="results"
        />
        <ResultsBox
            :loading="loading"
        />
    </div>
</template>

<script>
import SearchBox from "../Shared/SearchBox.vue";
import ResultsBox from "../Shared/ResultsBox.vue";
import {defineComponent} from "vue";

export default defineComponent({
    name: "Home",
    components: {SearchBox, ResultsBox},
    data() {
        return {
            loading: false,
            results: [],
        }
    }
})

</script>
