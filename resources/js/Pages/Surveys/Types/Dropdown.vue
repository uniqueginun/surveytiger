<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse">
            <template #title> {{ question.question_text }}</template>
            <select class="form-select" aria-label="select custom-select form-select" @change="updateForm">
                <option value="">Choose</option>
                <option v-for="answer of question.answers" :key="answer.id" :value="answer.id">{{ answer.answer_text }}</option>
            </select>
        </survey-response-form>
    </div>
</template>

<script>
import {responseFormMixin} from "../../../Utils/minxin";

export default {
    name: "Dropdown",

    mixins: [responseFormMixin],

    methods: {
        updateForm(e) {
            this.$emit('update-form', e.target.value, 'dropdown');
        }
    }
}
</script>

<style scoped>

</style>
