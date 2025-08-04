<template>
    <div class="flex justify-center gap-4 p-4">
        <PeopleDetails :id="id" />
    </div>
</template>

<script>
import {defineComponent} from "vue";
import PeopleDetails from "../Shared/PeopleDetails.vue";

export default defineComponent({
    name: "People",
    components: {PeopleDetails},
    props: {
        id: String,
    },
})

</script>
