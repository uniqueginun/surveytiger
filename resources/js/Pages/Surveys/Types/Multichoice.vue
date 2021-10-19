<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form v-if="!preview" @skipped="skip" @submitted="sendResponse">
            <template #title> {{ question.question_text }}</template>
            <div v-for="(answer, index) of question.answers" :key="index" class="form-check">
                <input :id="`answerCheck${answer.id}`" v-model="multichoice" :value="answer.id" class="form-check-input"
                       name="multichoice[]" type="checkbox">
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
    name: "Multichoice",

    components: { PreviewPercentage },

    mixins: [ responseFormMixin ],

    data() {
        return {
            multichoice: []
        }
    },

    methods: {
        sendResponse() {
            this.$store.dispatch('setFormElement', {
                type: 'multichoice',
                question_id: this.question.id,
                value: this.multichoice
            });
        },
    }
}
</script>
