<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="h4 font-weight-bold">My Surveys</h2>
    </template>
    <survey-list :surveys="surveys" :categories="categories"></survey-list>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import SurveyList from "@/Survey/Index.vue";

export default defineComponent({
  props: {
    surveys: {
      type: Array,
      default: [],
    },
    categories: {
      type: Array,
      default: [],
    }
  },
  components: {
    AppLayout,
    SurveyList,
  },
});
</script>
