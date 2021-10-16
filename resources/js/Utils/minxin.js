import SurveyResponseForm from '@/Pages/Surveys/Partials/SurveyResponseForm.vue';


export const responseFormMixin = {
    components: {
        SurveyResponseForm
    },

    props: ['last', 'question'],

    methods: {
        sendResponse() {
            alert('submitted');
        },
        skip() {
            this.$emit('skip-question')
        }
    }
}
