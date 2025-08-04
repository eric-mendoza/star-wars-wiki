<template>
    <div class="flex justify-between py-1.5">
        <span class="flex-1 font-bold text-black text-sm">
            {{title}}
        </span>

        <button
            class="rounded-2xl bg-green-600 px-4 py-1 text-xs/4 font-semibold w-30 text-white hover:bg-green-700"
            @click="showDetails"
        >
            SEE DETAILS
        </button>
    </div>
</template>

<script>
export default {
    name: "ResultItem",
    props: {
        title: String,
        id: String,
        type: String,
    },
    methods: {
        showDetails() {
            switch (this.type) {
                case "PEOPLE":
                    this.$inertia.visit(`/people/${this.id}`);
                    break;
                case "MOVIES":
                    this.$inertia.visit(`/movies/${this.id}`);
                    break;
                default:
                    break;
            }
        }
    }
}
</script>

<style scoped>

</style>
