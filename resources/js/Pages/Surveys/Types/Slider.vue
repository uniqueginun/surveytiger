<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse" v-if="!preview">
            <template #title> {{ question.question_text }}</template>
            <div class="my-5">
                <slider-component v-model="center" :max="max" :min="min" @update="setSlider"/>
            </div>
        </survey-response-form>
        <preview-card v-else :questiontext="question.question_text">
            <slider-component v-model="center" :max="max" :min="min" :disabled="true" />
        </preview-card>
    </div>
</template>

<script>
import SliderComponent from '@vueform/slider'
import {responseFormMixin} from "../../../Utils/minxin";
import PreviewCard from "../Previews/PreviewCard";

export default {
    name: "Slider",

    mixins: [responseFormMixin],

    data: () => ({
        center: 0,
        min: 0,
        max: 100,
        slider: 0,
    }),

    methods: {
        sendResponse() {
            this.$store.dispatch('setFormElement', {
                type: 'slider',
                question_id: this.question.id,
                value: this.slider
            });
        },

        setSlider(v) {
            this.slider = v;
        }
    },

    components: {
        PreviewCard,
        SliderComponent
    },

    created() {
        const {min, max, center} = this.question.pivot
        this.min = min
        this.max = max
        this.center = center

        if (this.preview) {
            this.center = this.question.question_results
        }
    }
}
</script>

<style src="@vueform/slider/themes/default.css"></style>
