<template>
    <preview-card :questiontext="question.question_text">
        <div v-for="(answer, index) of answers" :key="index" class="progress mb-2" style="height: 2rem;">
            <div
                aria-valuemax="100"
                aria-valuemin="0"
                :aria-valuenow="answer.percentage"
                class="progress-bar"
                role="progressbar"
                :style="`width: ${answer.percentage}%`">
                {{ answer.answer_text }} ({{ answer.percentage }}%)
            </div>
        </div>
    </preview-card>
</template>

<script>

import PreviewCard from "./PreviewCard";
import {percentageMixin} from "../../../Utils/minxin";

export default {
    name: "PreviewPercentage",

    components: {PreviewCard},

    props: ['question'],

    mixins: [percentageMixin]
}

</script>

<style scoped>
    .progress-bar {
        background-color: #38c172;
        text-align: start;
        padding-left: 10px;
    }
</style>
