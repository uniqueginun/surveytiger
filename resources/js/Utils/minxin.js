import SurveyResponseForm from '@/Pages/Surveys/Partials/SurveyResponseForm.vue';


export const responseFormMixin = {
    components: {
        SurveyResponseForm
    },

    props: {
        last: Boolean,
        question: Object,
        preview: {
            type: Boolean,
            default: false
        }
    },

    methods: {
        sendResponse() {
            alert('submitted');
        },
        skip() {
            this.$emit('skip-question')
        }
    }
}

export const percentageMixin = {
    methods: {
        getPercentage(id) {
            if (! this.results[id]) return 0;
            return ((this.results[id] / this.total) * 100).toFixed(2);
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
