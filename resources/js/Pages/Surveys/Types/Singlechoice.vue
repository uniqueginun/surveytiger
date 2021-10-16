<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse">
            <template #title> {{ question.question_text }}</template>
            <div v-for="(answer, index) of question.answers" :key="index" class="form-check">
                <input :id="`answerCheck${answer.id}`" :value="answer.id" class="form-check-input" name="survey[radio]" type="radio"
                       @input="updateForm">
                <label :for="`answerCheck${answer.id}`" class="form-check-label">
                    {{ answer.answer_text }}
                </label>
            </div>
        </survey-response-form>
    </div>
</template>

<script>
import {responseFormMixin} from "../../../Utils/minxin";

export default {
    name: "Singlechoice",

    mixins: [responseFormMixin],

    methods: {
        updateForm(e) {
            this.$emit('update-form', e.target.value, 'singlechoice');
        }
    }
}
</script>

<style scoped>

</style>
