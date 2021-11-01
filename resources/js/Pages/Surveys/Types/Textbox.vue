<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse" v-if="!preview">
            <template #title> {{ question.question_text }}</template>
            <div>
                <input type="text" v-model="textAnswer" class="form-control" maxlength="255">
            </div>
        </survey-response-form>
        <preview-card v-else :questiontext="question.question_text">
            <p v-for="(t, index) of question.question_results" :key="index">
                {{ t.answer_text }}
            </p>
        </preview-card>
    </div>
</template>

<script>
import {responseFormMixin} from "../../../Utils/minxin";
import PreviewCard from "../Previews/PreviewCard";

export default {
    name: "Textbox",
    components: {PreviewCard},
    mixins: [responseFormMixin],

    data() {
        return {
            textAnswer: ''
        }
    },

    methods: {
        sendResponse() {
            this.$store.dispatch('setFormElement', {
                type: 'textbox',
                question_id: this.question.id,
                value: this.textAnswer
            });
        }
    }
}
</script>

<style scoped>

</style>
