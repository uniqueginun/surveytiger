<template>
    <div>
        <thank-you-for-taking v-if="doneTakingSurvey"></thank-you-for-taking>
        <taking-survey v-else :survey="survey" :types="types"></taking-survey>
    </div>
</template>

<script>

import {defineComponent} from "vue";

import ThankYouForTaking from './Previews/ThankYouForTaking'
import TakingSurvey from "./Previews/TakingSurvey";

export default defineComponent({
    components: {ThankYouForTaking, TakingSurvey},

    props: ['survey', 'types'],

    computed: {
        doneTakingSurvey() {
            return this.$store.getters.successResponse
        }
    },

    created() {
        this.$store.commit('answerAnonymously')
    }
});
</script>
