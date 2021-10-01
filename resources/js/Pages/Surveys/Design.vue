<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="h4 font-weight-bold">Design your survey</h2>
    </template>
    <div>
      
      <!-- breadcrumb -->
      <survey-crumb v-on:changed="crumbChanged" :activeCrumb="activeCrumb" />

      <!-- Update survey information -->
      <div>
        <update-survey-information-form
          :survey="survey"
          :categories="categories"
        />

        <jet-section-border />
      </div>

      <!-- Design questions -->
      <div>
        <design-questions :survey="survey" />

        <jet-section-border />
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import UpdateSurveyInformationForm from "@/Pages/Surveys/Partials/UpdateSurveyInformationForm.vue";
import DesignQuestions from "@/Pages/Surveys/Partials/DesignQuestions.vue";
import SurveyCrumb from "./SurveyCrumb.vue";

export default defineComponent({
  data: () => ({
    activeCrumb: "DESIGN SURVEY"
  }),
  methods: {
    crumbChanged(crumb) {
      this.activeCrumb = crumb;
    }
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
  },
  components: {
    AppLayout,
    JetSectionBorder,
    UpdateSurveyInformationForm,
    DesignQuestions,
    SurveyCrumb
  },
});
</script>

    