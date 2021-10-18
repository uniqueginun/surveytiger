<template>
    <div class="container">
        <component
            v-for="(question, index) of survey.questions"
            :is="question.type.name"
            v-show="showQuestion(index)"
            :key="question.id"
            :question="question"
            :last="index ===  survey.questions.length-1"
            @skip-question="nextQuestion"
        />
    </div>
</template>

<script>

import Multichoice from "../Types/Multichoice";
import Singlechoice from "../Types/Singlechoice";
import Dropdown from "../Types/Dropdown";
import Rating from "../Types/Rating";
import Ranking from "../Types/Ranking";
import Slider from "../Types/Slider";
import Textbox from "../Types/Textbox";

export default {
    name: "PreviewQuestions",

    props: ["survey", "types"],

    components: {
        Multichoice,
        Singlechoice,
        Dropdown,
        Ranking,
        Rating,
        Slider,
        Textbox
    },

    methods: {
        isActive(index) {
            return parseInt(index) === parseInt(this.activeIndex);
        },

        nextQuestion() {

            if(this.activeIndex+1 === this.survey.questions.length) {
               return;
            }

            this.$store.commit('increment');
        },

        showQuestion(index) {
            return this.isActive(index);
        }
    },

    computed: {
        activeIndex() {
            return this.$store.getters.activeIndex;
        }
    },

    created() {
        this.$store.commit('setSurvey', this.survey)
    }
}
</script>
