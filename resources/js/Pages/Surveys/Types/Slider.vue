<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse">
            <template #title> {{ question.question_text }}</template>
            <div class="my-5">
                <slider-component v-model="center" :max="max" :min="min" @update="setSlider"/>
            </div>
        </survey-response-form>
    </div>
</template>

<script>
import SliderComponent from '@vueform/slider'
import {responseFormMixin} from "../../../Utils/minxin";

export default {
    name: "Slider",

    mixins: [responseFormMixin],

    data: () => ({
        center: 30,

        slider: 0,
    }),

    computed: {
        min() {
            return 12;
        },

        max() {
            return 100;
        }
    },

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
        SliderComponent
    }
}
</script>

<style src="@vueform/slider/themes/default.css"></style>
