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
        <form v-else>
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">{{ question.question_text }}</div>
                    <div class="card-body">
                        <div v-for="(answer, index) of answers" :key="index" class="progress mb-2" style="height: 2rem;">
                            <div
                                aria-valuemax="100"
                                aria-valuemin="0"
                                :aria-valuenow="answer.percentage"
                                class="progress-bar"
                                role="progressbar"
                                :style="`width: ${answer.percentage}%`">
                                {{ answer.answer_text }} ({{ answer.percentage }}%)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>

import {responseFormMixin} from "../../../Utils/minxin";

export default {
    name: "Multichoice",

    mixins: [responseFormMixin],

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

        getPercentage(id) {
            return (this.results[id] / this.total) * 100;
        }
    },

    computed: {
        results() {
            return Object.assign(
                {},
                ...(this.question.question_results.map(item => {
                    return {[item.id]: item.answer_count};
                }))
            );
        },

        total() {
            return Object.values(this.results).reduce((a, b) => a + b, 0);
        },

        answers() {
            return this.question.answers.map((answer) => {
                answer['percentage'] = this.getPercentage(answer.id);
                return answer;
            })
        }
    }
}
</script>

<style scoped>
    .progress-bar {
        background-color: #38c172;
        text-align: start;
        padding-left: 10px;
    }
</style>
