<template>
    <div class="flex justify-center gap-4 p-4">
        <StatisticsDetails />
    </div>
</template>

<script>
import {defineComponent} from "vue";
import StatisticsDetails from "../Shared/StatisticsDetails.vue";

export default defineComponent({
    name: "Statistics",
    components: {StatisticsDetails},
    props: {
        id: String,
    },
})

</script>
