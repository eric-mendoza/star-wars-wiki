<template>
    <Card class="w-1/2 h-[50vh] min-w-md max-w-[700px]">
        <!--    Loading    -->
        <template v-if="loading">
            <div class="flex justify-center items-center h-full">
                <div class="w-8 h-8 border-4 border-green-600 border-dashed rounded-full animate-spin"></div>
            </div>
        </template>

        <!--    Movie    -->
        <template v-else-if="statistics">
            <h2 class="font-bold mb-4 min-h-0">Statistics</h2>
            <horizontal-rule />

            <div class="mt-4 grid grid-cols-1 gap-1 text-sm">
                <div class="flex gap-x-3">
                    <span class="font-bold text-gray-700">Total Searches:</span>
                    <span class="text-gray-900">{{ statistics.total }}</span>
                </div>

                <div class="flex gap-x-3">
                    <span class="font-bold text-gray-700">Avg Duration (s):</span>
                    <span class="text-gray-900">{{ statistics.avg_duration.toFixed(3) }}ms</span>
                </div>

                <div class="flex gap-x-3">
                    <span class="font-bold text-gray-700">Popular Hour:</span>
                    <span class="text-gray-900">{{ statistics.popular_hour }}:00 (UTC)</span>
                </div>

                <div>
                    <span class="font-bold text-gray-700">Top Locations:</span>
                    <ul class="ml-4 mt-1 list-disc text-gray-900">
                        <li v-for="(count, location) in statistics.top_locations" :key="location">
                            {{ location || 'Unknown' }} - {{ count }}
                        </li>
                    </ul>
                </div>

                <div>
                    <span class="font-bold text-gray-700">Top Browsers:</span>
                    <ul class="ml-4 mt-1 list-disc text-gray-900">
                        <li v-for="(count, browser) in statistics.top_browsers" :key="browser">
                            {{ browser }} - {{ count }}
                        </li>
                    </ul>
                </div>

                <div>
                    <span class="font-bold text-gray-700">Top Endpoints:</span>
                    <ul class="ml-4 mt-1 mb-2 list-disc text-gray-900">
                        <li v-for="(count, endpoint) in statistics.top_endpoints" :key="endpoint">
                            {{ endpoint }} - {{ count }}
                        </li>
                    </ul>
                </div>
            </div>
        </template>

        <a
            class="rounded-2xl text-center bg-green-600 px-4 py-1 text-xs/4 font-semibold text-white w-40 mt-auto hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed"
            href="/"
        >
            BACK TO SEARCH
        </a>
    </Card>

</template>

<script>
import {defineComponent} from "vue";
import Card from "../Atoms/Card.vue";
import HorizontalRule from "../Atoms/HorizontalRule.vue";
import {getMovieById} from "../api/getMovieById.js";
import {getStatistics} from "../api/getStatistics.js";

export default defineComponent({
    name: "StatisticsDetails",
    components: {HorizontalRule, Card},
    props: {},
    mounted() {
        this.fetchStatistics()
    },
    data() {
        return {
            loading: false,
            statistics: null,
        }
    },
    methods: {
        async fetchStatistics() {
            this.loading = true;
            try {
                this.statistics = await getStatistics();
            } catch (error) {
                console.error(error);
                this.$toast?.error?.(
                    error?.response?.data?.message || "Error fetching statistics.",
                );
            } finally {
                this.loading = false;
            }
        }
    }
})

</script>
<style scoped>
.properties {
    span {
        font-size: 14px;
        line-height: normal;
    }
}
</style>
