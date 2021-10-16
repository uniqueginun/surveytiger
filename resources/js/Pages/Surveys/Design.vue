<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="h4 font-weight-bold">Design your survey</h2>
        </template>
        <div>
            <!-- breadcrumb -->
            <survey-crumb :activeCrumb="activeCrumb" v-on:changed="crumbChanged"/>

            <div v-show="isDesigning">
                <!-- Update survey information -->
                <update-survey-information-form
                    :categories="categories"
                    :survey="survey"
                />

                <jet-section-border/>

                <!-- Design questions -->
                <design-questions :survey="survey" :types="types"/>
            </div>

            <div v-show="!isDesigning">
                <preview-questions :survey="survey" :types="types"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import UpdateSurveyInformationForm from "@/Pages/Surveys/Partials/UpdateSurveyInformationForm.vue";
import DesignQuestions from "@/Pages/Surveys/Partials/DesignQuestions.vue";
import PreviewQuestions from "@/Pages/Surveys/Partials/PreviewQuestions.vue";
import SurveyCrumb from "./SurveyCrumb.vue";

export default defineComponent({
    data: () => ({
        activeCrumb: "Survey design",
    }),
    methods: {
        crumbChanged(crumb) {
            this.activeCrumb = crumb;
        },
    },
    props: {
        survey: {
            type: Object,
            required: true,
        },
        categories: {
            type: Array,
            default: [],
        },
        types: {
            type: Array,
            default: [],
        },
    },
    computed: {
        isDesigning() {
            return this.activeCrumb === "Survey design";
        },
    },
    components: {
        AppLayout,
        JetSectionBorder,
        UpdateSurveyInformationForm,
        DesignQuestions,
        PreviewQuestions,
        SurveyCrumb,
    },
});
</script>

