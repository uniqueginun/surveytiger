<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse" v-if="!preview">
            <template #title> {{ question.question_text }}</template>
            <div v-for="(answer, index) of question.answers" :key="index" class="form-check">
                <input :id="`answerCheck${answer.id}`" :value="answer.id" class="form-check-input" name="survey[radio]" v-model="selectedValue" type="radio">
                <label :for="`answerCheck${answer.id}`" class="form-check-label">
                    {{ answer.answer_text }}
                </label>
            </div>
        </survey-response-form>
        <preview-percentage v-else :question="question" />
    </div>
</template>

<script>
import { responseFormMixin } from "../../../Utils/minxin";
import PreviewPercentage from "../Previews/PreviewPercentage";

export default {
    name: "Singlechoice",
    components: {PreviewPercentage},


    mixins: [responseFormMixin],

    data() {
        return {
            selectedValue: ''
        }
    },

    methods: {
        sendResponse() {
            this.$store.dispatch('setFormElement', {
                type: 'singlechoice',
                question_id: this.question.id,
                value: this.selectedValue
            });
        },

        updateForm(e) {
            this.selectedValue(e.target.value);
        }
    }
}
</script>
