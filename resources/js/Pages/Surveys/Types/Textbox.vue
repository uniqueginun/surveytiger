<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse">
            <template #title> {{ question.question_text }}</template>
            <div>
                <input type="text" @input="setFormValue" class="form-control" maxlength="255">
            </div>
        </survey-response-form>
    </div>
</template>

<script>
import {responseFormMixin} from "../../../Utils/minxin";

export default {
    name: "Textbox",

    mixins: [responseFormMixin],

    methods: {
        setFormValue(e) {
            this.$emit('update-form', e.target.value, 'textbox');
        }
    }
}
</script>

<style scoped>

</style>
