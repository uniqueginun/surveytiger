<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @submitted="sendResponse" @skipped="skip">
            <template #title> {{ question.question_text }} </template>
            <div v-for="(answer, index) of question.answers" :key="index" class="form-check">
                <input :id="`answerCheck${answer.id}`" v-model="multichoice" :value="answer.id" class="form-check-input"
                       name="multichoice[]" type="checkbox">
                <label :for="`answerCheck${answer.id}`" class="form-check-label">
                    {{ answer.answer_text }}
                </label>
            </div>
        </survey-response-form>
    </div>
</template>

<script>

import { responseFormMixin } from "../../../Utils/minxin";

export default {
    name: "Multichoice",

    mixins: [responseFormMixin],

    data() {
        return {
            multichoice: [],

            form: this.$inertia.form({
                multichoice: []
            }),
        }
    }
}
</script>

<style scoped>

</style>
