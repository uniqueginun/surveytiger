<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse" v-if="!preview">
            <template #title> {{ question.question_text }}</template>
            <select class="form-select" aria-label="select custom-select form-select" v-model="selectedValue">
                <option value="">Choose</option>
                <option v-for="answer of question.answers" :key="answer.id" :value="answer.id">{{ answer.answer_text }}</option>
            </select>
        </survey-response-form>
        <preview-percentage v-else :question="question" />
    </div>
</template>

<script>
import {responseFormMixin} from "../../../Utils/minxin";
import PreviewPercentage from "../Previews/PreviewPercentage";

export default {
    name: "Dropdown",
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
                type: 'multichoice',
                question_id: this.question.id,
                value: this.selectedValue
            });
        }
    }
}
</script>

<style scoped>

</style>
