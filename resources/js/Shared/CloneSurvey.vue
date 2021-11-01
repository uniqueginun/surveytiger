<template>
  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <button
        class="nav-link active"
        id="nav-home-tab"
        data-bs-toggle="tab"
        data-bs-target="#nav-home"
        type="button"
        role="tab"
        aria-controls="nav-home"
        aria-selected="true"
      >
        Edit Survey Info
      </button>
      <button
        class="nav-link"
        id="nav-profile-tab"
        data-bs-toggle="tab"
        data-bs-target="#nav-profile"
        type="button"
        role="tab"
        aria-controls="nav-profile"
        aria-selected="false"
      >
        Select Questions
      </button>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div
      class="tab-pane fade show active"
      id="nav-home"
      role="tabpanel"
      aria-labelledby="nav-home-tab"
    >
      <div class="card-body">
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
          <select id="category" class="form-select" v-model="form.category_id">
            <option value="">choose one ...</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
              {{ cat.name }}
            </option>
          </select>
          <div v-if="form.errors.category_id" class="invalid-feedback">
            {{ form.errors.category_id }}
          </div>
        </div>
      </div>
    </div>
    <div
      class="tab-pane fade"
      id="nav-profile"
      role="tabpanel"
      aria-labelledby="nav-profile-tab"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <ul class="list-group" v-if="questionsList.length">
              <li
                class="list-group-item bg-success text-white font-weight-bold"
              >
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="selectAllQuestions"
                    v-model="selectAllQuestions"
                  />
                  <label class="form-check-label" for="selectAllQuestions">
                    Select all questions
                  </label>
                </div>
              </li>
              <li
                v-for="(item, index) of questionsList"
                :key="index"
                class="list-group-item"
              >
                <div class="d-flex align-items-center justify-content-between">
                  <label>{{ item.question_text }}</label>
                  <a
                    v-on:click.prevent="addQuestion(item)"
                    href="#"
                    title="add question to cloned survey"
                  >
                    <i class="fas fa-angle-double-right"></i>
                  </a>
                </div>
              </li>
            </ul>
            <div class="card question-block h-100" v-else>
              <div class="card-body">
                <div class="text-muted">You've selected all questions.</div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="mb-4" v-if="selectedQuestions.length">
              <a
                v-on:click.prevent="form.questions = []"
                href="#"
                title="remove all selected questions"
                class="btn btn-danger text-white"
              >
                <i class="fas fa-angle-double-left"></i>
                Deselect all questions.
              </a>
            </div>
            <div class="card question-block h-100" v-else>
              <div class="card-body">
                <div class="text-muted">
                  Select questions from the list on the left.
                </div>
              </div>
            </div>
            <div class="row" v-for="(q, i) of selectedQuestions" :key="i">
              <div class="col-12">
                <div class="card mb-2 question-block">
                  <div
                    class="
                      card-body
                      d-flex
                      align-items-center
                      justify-content-between
                    "
                  >
                    <label>{{ q.question_text }}</label>
                    <a
                      v-on:click.prevent="removeQuestion(q.id)"
                      href="#"
                      title="remove this question"
                    >
                      <i class="fas fa-minus text-danger"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-4 d-flex justify-content-center">
    <button
      type="button"
      class="btn btn-success text-white w-100"
      v-on:click.prevent="cloneSurvey"
      :disabled="form.processing"
    >
      <div
        v-show="form.processing"
        class="spinner-border spinner-border-sm"
        role="status"
      >
        <span class="visually-hidden">Loading...</span>
      </div>
      Clone this survey
    </button>
  </div>
</template>

<script>
import Label from "../Jetstream/Label.vue";
export default {
  components: { Label },
  props: {
    survey: {
      type: Object,
      required: true,
    },
    categories: {
      type: Array,
      required: true,
    },
  },

  computed: {
    questionsList() {
      const list = this.survey?.questions || [];
      return list.filter(
        (item) => !this.form.questions.find((q) => q.id === item.id)
      );
    },

    selectedQuestions() {
      return this.form.questions;
    },
  },

  methods: {
    cloneSurvey() {
      this.prepareForm().then(() => {
        this.form.post(route("surveys.clone"), {
          preserveScroll: true,
          onSuccess: () => {
            this.form.reset();
            toaster(this.$page.props.jetstream.flash);
          },
          onError: (err) => console.log(err),
        });
      });
    },

    prepareForm() {
       return new Promise((resolve) => {
          this.form.questions = this.form.questions.map((q) => {
             return {
                details: q.pivot,
                answers: q.answers.map(answer => answer.id),
             }
          });
          resolve();
       });
    },

    addQuestion(q) {
      this.form.questions.push(q);
    },

    removeQuestion(id) {
      this.form.questions = this.form.questions.filter(
        (item) => item.id !== id
      );
    },
  },

  watch: {
    selectAllQuestions(value) {
      if (value) {
        this.form.questions = this.survey.questions;
      }
    },

    selectedQuestions(list) {
      if (list.length < this.survey.questions.length) {
        this.selectAllQuestions = false;
      }
    },
  },

  data() {
    return {
      selectAllQuestions: false,
      form: this.$inertia.form({
        name: "",
        category_id: "",
        description: "",
        questions: [],
      }),
    };
  },

  created() {
    const { name, description, category_id } = this.survey;
    this.form.name = name;
    this.form.category_id = category_id;
    this.form.description = description;
  },
};
</script>

<style scoped>
.question-block {
  border-radius: 0.475rem;
  border: 1px solid #e3e3e3;
}
</style>