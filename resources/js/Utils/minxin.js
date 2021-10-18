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
