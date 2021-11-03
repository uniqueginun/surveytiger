<template>
  <add-question
    v-if="editingMode"
    :questiontypes="questiontypes"
    :survey="survey"
    :question_text="question.question_text"
    :question_type_id="question.pivot.question_type_id + ''"
    :updating="question.id"
    :answers="answers"
    :questionSurvey="questionSurvey"
    @questionUpdated="questionUpdated"
  >
    <template #closeEdit>
      <jet-danger-button
        class="btn-light mr-2"
        :dark="true"
        v-on:click.prevent="toggleEditing"
      >
        Cancel
      </jet-danger-button>
    </template>
  </add-question>

  <div
    v-else
    class="row mb-3"
    @mouseenter="handleMouseEvent('enter')"
    @mouseleave="handleMouseEvent('out')"
  >
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-body bg-light">
          <div
            class="d-flex align-items-center justify-content-between mb-3"
            style="min-height: 40px"
          >
            <span class="fw-bold">
              {{ question.question_text }}
            </span>
            <div
              v-show="isDeleting"
              class="spinner-border text-danger"
              role="status"
            >
              <span class="visually-hidden">Loading...</span>
            </div>
            <div v-show="showButtons && !isDeleting">
              <a
                class="mx-2 btn btn-warning"
                type="button"
                v-on:click.prevent="toggleEditing"
              >
                <i class="fas fa-pencil"></i>
              </a>
              <a
                class="btn btn-danger"
                type="button"
                v-on:click.prevent="openModal"
              >
                <i class="fas fa-times"></i>
              </a>
            </div>
          </div>
          <ol class="list-group list-group-numbered">
            <li
              v-for="(item, index) in answers"
              :key="index"
              class="list-group-item"
              :class="[
                index % 2 === 0
                  ? 'list-group-item-dark'
                  : 'list-group-item-light',
              ]"
            >
              {{ item.answer_text }}
            </li>
          </ol>
          <div v-if="questionSurvey?.is_slider">
            <p class="text-muted">Min: {{ questionSurvey.min }}</p>
            <p class="text-muted">Center: {{ questionSurvey.center }}</p>
            <p class="text-muted">Max: {{ questionSurvey.max }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import AddQuestion from "./AddQuestion.vue";
import {
  useAnswers,
  useDeleteQuestion,
  useUpdateQuestion,
} from "@/Composable/SurveyQuestionAnswer.js";
import JetDangerButton from "@/Jetstream/DangerButton.vue";

export default {
  components: {
    AddQuestion,
    JetDangerButton,
  },
  props: {
    question: {
      type: Object,
      required: true,
    },
    survey: {
      type: Object,
      required: true,
    },
    questiontypes: {
      type: Array,
      required: true,
    },
  },
  setup(props, { emit }) {
    const showButtons = ref(false);

    const handleMouseEvent = (action) => {
      showButtons.value = action === "enter";
    };

    const { question, survey } = props;

    const { answers, questionSurvey, loadAnswers } = useAnswers(
      survey.id,
      question.id
    );

    const { isDeleting, deleteQuestion } = useDeleteQuestion(
      survey.id,
      question.id
    );

    const { toggleEditing, editingMode } = useUpdateQuestion(
      survey.id,
      question.id
    );

    const questionUpdated = () => {
      toggleEditing();
      loadAnswers();
    };

    const openModal = () => {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          deleteQuestion();
        }
      });
    };

    onMounted(() => loadAnswers());

    return {
      openModal,
      handleMouseEvent,
      showButtons,
      answers,
      isDeleting,
      toggleEditing,
      editingMode,
      questionUpdated,
      questionSurvey,
    };
  },
};
</script>

<style scoped>
.mh40 {
  max-height: 40px !important;
}
</style>