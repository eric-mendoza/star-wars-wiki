<template>
    <div class="flex justify-center gap-4 p-4">
        <MoviesDetails :id="id" />
    </div>
</template>

<script>
import {defineComponent} from "vue";
import MoviesDetails from "../Shared/MoviesDetails.vue";

export default defineComponent({
    name: "Movies",
    components: {MoviesDetails},
    props: {
        id: String,
    },
})

</script>
