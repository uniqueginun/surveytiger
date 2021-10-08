<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <div class="px-4 px-sm-0">
          <div class="d-flex justify-content-between">
            <div>
              <h3 class="h5">Survey's Questions</h3>
              <p class="mt-1 text-muted">
                <span> Edit and create new questions </span>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <add-question :questiontypes="types" :survey="survey" :question_text="''" :question_type_id="''" :answers="null"></add-question>
        <h5 class="text-muted fs-6" v-if="!survey.questions.length">No questions were added to this one</h5>
        <survey-question
          v-for="(question, index) of survey.questions"
          :key="index"
          :question="question"
          :survey="survey"
          :questiontypes="types"
        >
        </survey-question>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import AddQuestion from "./AddQuestion.vue";
import SurveyQuestion from "./SurveyQuestion.vue";

export default defineComponent({
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    AddQuestion,
    SurveyQuestion,
  },

  props: ["survey", "types"],

  data() {
    return {
      questions: [],
    };
  },

  methods: {},
});
</script>
