<template>
  <div class="container d-flex py-3 bg-white shadow-sm border-bottom mb-5">
    <nav class="survey-nav" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li
          v-for="(item, index) in crumbs"
          :key="index"
          class="breadcrumb-item"
          :class="{ active: activeCrumb === item.name }"
          aria-current="page"
        >
          <a v-on:click.prevent="crumbClick(item)" :href="item.link">{{
            item.name
          }}</a>
        </li>
      </ol>
    </nav>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "SurveyCrumb",
  props: ["activeCrumb"],
  data: () => ({
    crumbs: [
      {
        name: "Survey design",
        link: "#",
      },
      {
        name: "Preview and score",
        link: "#",
      },
    ],
  }),
  methods: {
    crumbClick(crumb) {
      this.$emit("changed", crumb.name);
    },
  },
});
</script>

<style scoped>
.survey-nav {
  --bs-breadcrumb-divider: url(
    data:image/svg + xml,
    width="8"height="8"path="M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z"fill="currentColor"
  );
}

ol.breadcrumb {
  padding-bottom: 0px !important;
}

.breadcrumb-item a {
  text-decoration: none !important;
  color: #6c757d;
}

.breadcrumb-item.active a {
  color: #38c172;
  font-weight: bold;
}
</style>