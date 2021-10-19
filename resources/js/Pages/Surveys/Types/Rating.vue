<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse" v-if="!preview">
            <template #title> {{ question.question_text }}</template>
            <div class="d-flex align-items-center">
                <star-rating
                    :animate="true"
                    :max-rating="maxRating"
                    :rating="rating"
                    :show-rating="false"
                    :star-size="30"
                    active-color="#38c172"
                    inactive-color="#cbecd9"
                    @update:rating="setRating"
                    @hover:rating="showRating"
                />
                <div>{{ ratingText }}</div>
            </div>
        </survey-response-form>
        <preview-card v-else :questiontext="question.question_text">
            <div class="d-flex align-items-center">
                <star-rating
                    :max-rating="maxRating"
                    :rating="rating"
                    :show-rating="false"
                    :star-size="30"
                    active-color="#38c172"
                    inactive-color="#cbecd9"
                    :read-only="true"
                    @update:rating="setRating"
                    @hover:rating="showRating"
                />
                <div>{{ ratingText }}</div>
            </div>
        </preview-card>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating';
import {responseFormMixin} from "../../../Utils/minxin";
import PreviewCard from "../Previews/PreviewCard";

export default {
    name: "Rating",

    mixins: [responseFormMixin],

    data: () => ({
        rating: 1,
        ratingText: ''
    }),

    methods: {
        sendResponse() {
            const answer = this.getAnswer(this.rating - 1);
            this.$store.dispatch('setFormElement', {
                type: 'rating',
                question_id: this.question.id,
                value: answer.id
            });
        },

        showRating(r) {
            this.setRatingText(r);
        },

        setRatingText(r) {
            const answer = this.getAnswer(r - 1);
            this.ratingText = answer.answer_text;
        },

        setRating(r) {
            this.rating = r;
        },

        getAnswer(index) {
            return this.question.answers.find((_, i) => i === index);
        }
    },

    computed: {
        maxRating() {
            return this.question.answers.length;
        }
    },

    components: {
        PreviewCard,
        StarRating
    },

    created() {
        if (this.preview && this.question?.question_results) {
            const index = this.question.answers.findIndex(item => item.id == this.question.question_results);
            this.rating = (index + 1);
        }
        this.setRatingText(this.rating);
    }
}
</script>

<style scoped>
.vue-star-rating {
    margin-right: 10px;
}
</style>
