<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse">
            <template #title> {{ question.question_text }}</template>
            <div>
                <input type="text" v-model="textAnswer" class="form-control" maxlength="255">
            </div>
        </survey-response-form>
    </div>
</template>

<script>
import {responseFormMixin} from "../../../Utils/minxin";

export default {
    name: "Textbox",

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
