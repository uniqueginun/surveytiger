<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="h4 font-weight-bold">Create Survey</h2>
    </template>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="title"
                  v-model="form.name"
                />
                <div v-if="form.errors.name" class="invalid-feedback">
                  {{ form.errors.name }}
                </div>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea
                  class="form-control"
                  id="description"
                  v-model="form.description"
                  rows="3"
                ></textarea>
                <div v-if="form.errors.description" class="invalid-feedback">
                  {{ form.errors.description }}
                </div>
              </div>
              <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select
                  id="category"
                  class="form-select"
                  v-model="form.category_id"
                >
                  <option value="">choose one ...</option>
                  <option
                    v-for="cat in categories"
                    :key="cat.id"
                    :value="cat.id"
                  >
                    {{ cat.name }}
                  </option>
                </select>
                <div v-if="form.errors.category_id" class="invalid-feedback">
                  {{ form.errors.category_id }}
                </div>
              </div>
              <div class="mb-3">
                <button
                  type="button"
                  @click.prevent="setSubmit('create')"
                  class="btn btn-success text-white"
                >
                  Create and enter questions
                </button>
                <button
                  type="button"
                  @click.prevent="setSubmit('save')"
                  class="btn btn-info text-white mx-2"
                >
                  Save for later use
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import iziToast from "izitoast";

export default defineComponent({
  props: {
    categories: {
      type: Array,
      default: [],
    },
  },
  components: {
    AppLayout,
  },
  data: function () {
    return {
      form: this.$inertia.form({
        action: "create",
        name: "",
        category_id: "",
        description: "",
      }),
    };
  },
  methods: {
    makeSurvey: function () {
      this.form.post(this.route("surveys.store"), {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          iziToast.show({
            title: "Success",
            message: this.$page.props.jetstream.flash || "Survey was created!",
            theme: "light", 
            color: "green", 
            position: 'bottomRight'
          });
        },
        onError: (err) => console.log(err),
      });
    },
    setSubmit: function (submit) {
      this.form.action = submit;
      this.makeSurvey();
    },
  },
});
</script>
