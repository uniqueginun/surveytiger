<template>
  <div class="container-fluid">
    <div
      class="offcanvas offcanvas-top bg-indigo text-white text-center"
      tabindex="-1"
      id="offcanvasTop"
      data-bs-scroll="true"
      data-bs-backdrop="false"
      aria-labelledby="offcanvasTopLabel"
    >
      <div class="offcanvas-header">
        <button
          type="button"
          class="btn-close text-reset"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body text-center">
        <h4>Thank you for taking this survey</h4>
      </div>
    </div>

    <div
      class="
        container-div
        d-flex
        align-items-center
        justify-content-center
        flex-column
      "
    >
      <div class="row justify-content-center text-center mb-5">
        <div class="col-12">
          <application-mark width="150"></application-mark>
        </div>
      </div>
      <div class="row justify-content-center text-center">
        <div class="col-12">
          <h3 class="sink">TigerMonkey (SVMK Inc.) is now Momentive</h3>
          <h6 class="sink mt-4 text-lg">
            Learn more about the AI-driven solutions we're developing to help
            decision-makers shape truly exceptional experiences.
          </h6>
        </div>
        <div class="col-12 mt-3">
          <Link :href="route('home')" class="btn btn-success btn-lg text-white"
            >Learn more</Link
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import ApplicationMark from "@/Jetstream/ApplicationMark.vue";

export default {
  name: "ThankYouForTaking.vue",

  components: {
    Link,
    ApplicationMark
  },

  mounted() {
    var myOffcanvas = document.getElementById("offcanvasTop");
    var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
    bsOffcanvas.show();
  },
};
</script>

<style scoped>
.offcanvas-top {
  height: 15vh !important;
}

.container-div {
  margin-top: 30vh;
}

.sink {
  color: cornsilk;
}
</style>
