<template>
    <Card class="w-1/2 h-[50vh] min-w-md max-w-[700px]">
        <!--    Loading    -->
        <template v-if="loading">
            <div class="flex justify-center items-center h-full">
                <div class="w-8 h-8 border-4 border-green-600 border-dashed rounded-full animate-spin"></div>
            </div>
        </template>

        <!--    Movie    -->
        <template v-else-if="movie">
            <h2 class="font-bold mb-4 min-h-0">{{movie.title}}</h2>
            <div class="flex justify-between min-h-0 flex-1 gap-10">
                <!--        Details        -->
                <div class="flex flex-col properties w-xs min-h-0">
                    <h3 class="font-bold">Opening Crawl</h3>
                    <horizontal-rule />

                    <span class="h-full overflow-y-auto mb-2">{{movie.opening_crawl}}</span>
                </div>

                <!--        Characters        -->
                <div class="flex flex-col properties w-xs min-h-0">
                    <h3 class="font-bold">Characters</h3>
                    <horizontal-rule />

                    <div class="flex-1 min-h-0 h-full overflow-y-auto">
                        <p class="text-blue-600 text-sm leading-tight">
                            <template v-for="(character, index) in movie.characters" :key="character.id">
                                <a
                                    :href="`/people/${character.id}`"
                                    class="hover:underline inline"
                                >
                                    {{ character.name }}
                                </a><span v-if="index < movie.characters.length - 1">, </span>
                            </template>
                        </p>
                    </div>
                    <span v-if="!movie.characters" class="text-gray-300 text-xs">
                        Not found
                    </span>
                </div>

            </div>
        </template>

        <!--    Not found    -->
        <template v-else>
            <div class="flex w-full h-full items-center justify-center text-xs text-gray-300 font-bold">
                NOT FOUND
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

export default defineComponent({
    name: "MoviesDetails",
    components: {HorizontalRule, Card},
    props: {
        id: String,
    },
    mounted() {
        this.fetchMoviesById(this.id)
    },
    data() {
        return {
            loading: false,
            movie: null,
        }
    },
    methods: {
        async fetchMoviesById(id) {
            this.loading = true;
            try {
                this.movie = await getMovieById(id);
            } catch (error) {
                console.error(error);
                this.$toast?.error?.(
                    error?.response?.data?.message || "Movie not found.",
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
