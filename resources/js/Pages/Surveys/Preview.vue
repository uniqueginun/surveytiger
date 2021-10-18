<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="h4 font-weight-bold">Survey's Result preview</h2>
        </template>
        <div class="container">
            <component
                v-for="(question, index) of resultSet"
                :is="question.type.name"
                :key="question.id"
                :question="question"
                :preview="true"
            />
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Multichoice from "./Types/Multichoice";
import Singlechoice from "./Types/Singlechoice";
import Dropdown from "./Types/Dropdown";
import Rating from "./Types/Rating";
import Ranking from "./Types/Ranking";
import Slider from "./Types/Slider";
import Textbox from "./Types/Textbox";

export default defineComponent({
    props: ['resultSet'],

    components: {
        AppLayout,
        Multichoice,
        Singlechoice,
        Dropdown,
        Ranking,
        Rating,
        Slider,
        Textbox
    },
});
</script>
