<template>
    <Card class="w-1/2 h-[50vh] min-w-md max-w-[700px]">
        <!--    Loading    -->
        <template v-if="loading">
            <div class="flex justify-center items-center h-full">
                <div class="w-8 h-8 border-4 border-green-600 border-dashed rounded-full animate-spin"></div>
            </div>
        </template>

        <!--    Person    -->
        <template v-else-if="person">
            <h2 class="font-bold mb-4">{{person.name}}</h2>
            <div class="flex justify-between min-h-0 flex-1 gap-10">
                <!--        Details        -->
                <div class="flex flex-col properties w-xs">
                    <h3 class="font-bold">Details</h3>
                    <horizontal-rule />

                    <span>Birth Year: {{person.birth_year}}</span>
                    <span>Gender: {{person.gender}}</span>
                    <span>Eye Color: {{person.eye_color}}</span>
                    <span>Hair Color: {{person.hair_color}}</span>
                    <span>Height: {{person.height}}</span>
                    <span>Mass: {{person.mass}}</span>
                </div>

                <!--        Movies        -->
                <div class="flex flex-col properties w-xs properties">
                    <h3 class="font-bold">Movies</h3>
                    <horizontal-rule />

                    <!--      TODO: BUG - SWAPI is not returning films with characters       -->
                    <a v-for="movie in person.movies" class="text-blue-600 hover:underline" :href="`/movies/${movie.id}`">
                        {{movie.title}}
                    </a>
                    <span v-if="!person.movies" class="text-gray-300 text-xs">
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
import {getPeopleById} from "../api/getPeopleById.js";
import HorizontalRule from "../Atoms/HorizontalRule.vue";

export default defineComponent({
    name: "PeopleDetails",
    components: {HorizontalRule, Card},
    mounted() {
        this.fetchPeopleById(this.id)
    },
    props: {
        id: String,
    },
    data() {
        return {
            loading: false,
            person: null,
        }
    },
    methods: {
        async fetchPeopleById(id) {
            this.loading = true;
            try {
                this.person = await getPeopleById(id);
            } catch (error) {
                console.error(error);
                this.$toast?.error?.(
                    error?.response?.data?.message || "Person not found.",
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

      a {
          font-size: 14px;
          line-height: normal;
      }
  }
</style>
