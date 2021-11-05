<template>
  <preview-card :questiontext="question.question_text">
    <div v-for="(answer, index) of answers" :key="index" class="mb-2">
      <div class="d-flex align-items-center justify-content-between mb-1">
        <span>{{ answer.answer_text }}</span>
        <span class="text-muted">{{ answer.percentage }}%</span>
      </div>
      <div class="progress mb-2" style="height: 10px">
        <div
          aria-valuemax="100"
          aria-valuemin="0"
          :aria-valuenow="answer.percentage"
          class="progress-bar"
          role="progressbar"
          :style="`width: ${answer.percentage}%`"
        ></div>
      </div>
    </div>
  </preview-card>
</template>

<script>
import PreviewCard from "./PreviewCard";
import { percentageMixin } from "../../../Utils/minxin";

export default {
  name: "PreviewPercentage",

  components: { PreviewCard },

  props: ["question"],

  mixins: [percentageMixin],
};
</script>

<style scoped>
.progress-bar {
  background-color: #38c172;
  text-align: start;
  padding-left: 10px;
}
</style>
