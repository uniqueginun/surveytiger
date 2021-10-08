<script>
import JetInput from "@/Jetstream/Input.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import Multichoice from "@/Shared/SurveyQuestionAnswers/Multichoice.vue";
import { reactive, computed, toRefs, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useUpdateQuestion } from "@/Composable/SurveyQuestionAnswer.js";

export default {
  components: {
    JetInput,
    JetButton,
    JetInputError,
    Multichoice,
  },

  props: {
    questiontypes: {
      type: Array,
      required: [],
    },
    survey: Object,
    question_text: String,
    question_type_id: String,
    answers: {
      default: null,
    },
    updating: {
      type: Number,
      default: 0,
    },
  },

  emits: ["questionUpdated"],

  setup(props, { emit }) {
    const {
      questiontypes,
      question_text,
      question_type_id,
      answers,
      updating,
    } = toRefs(props);

    const QuestionForm = reactive({
      question_text: question_text.value,
      question_type_id: question_type_id.value,
      answers: answers.value,
    });

    const formErrors = reactive({});

    const answersBLock = computed(() => {
      const type = questiontypes.value.find(
        (questiontype) => questiontype.id == QuestionForm.question_type_id
      );
      return type ? type.name : null;
    });

    const optionsChanged = (options) => {
      QuestionForm.answers = options;
    };

    const { isUpdating, updateQuestion } = useUpdateQuestion(
      props.survey.id,
      updating.value
    );

    watch(isUpdating, (status, _) => {
      (!status) && emit("questionUpdated");  
    });

    const saveQuestion = () => {
      if (updating.value) {
        updateQuestion(QuestionForm);
        return;
      }

      Inertia.post(route("surveys.design", props.survey.id), QuestionForm, {
        preserveScroll: true,
        onSuccess: () => {
          toaster("question was successfully added.");
          QuestionForm.question_text = question_text.value;
          QuestionForm.question_type_id = question_type_id.value;
          QuestionForm.answers = answers.value;
        },
        onError: (errors) => {
          formErrors.value = errors;
          toaster(errors.message, "Error", "danger", "red");
        },
      });
    };

    return {
      saveQuestion,
      questiontypes,
      QuestionForm,
      answersBLock,
      optionsChanged,
      formErrors,
      isUpdating,
    };
  },
};
</script>

<template>
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="mb-3 w-100 d-flex align-items-center">
            <div class="w-75">
              <jet-input
                id="question"
                type="text"
                placeholder="Question"
                autocomplete="question"
                v-model="QuestionForm.question_text"
              />
              <jet-input-error
                v-if="formErrors.value?.question"
                :message="formErrors.value?.question"
              />
            </div>
            <div class="w-25 mx-2">
              <select
                v-show="QuestionForm.question_text"
                id="type"
                class="form-select"
                v-model="QuestionForm.question_type_id"
              >
                <option value="">Choose type</option>
                <option
                  v-for="type in questiontypes"
                  :value="type.id"
                  :key="type.id"
                >
                  {{ type.name }}
                </option>
              </select>
            </div>
          </div>
          <component
            v-if="answersBLock"
            :is="answersBLock"
            :payload="QuestionForm.answers"
            @optionsChanged="optionsChanged"
          ></component>
        </div>
        <div class="card-footer d-flex justify-content-end">
          <slot name="closeEdit" />
          <jet-button @click.prevent="saveQuestion">
            <div
              v-show="isUpdating"
              class="spinner-border spinner-border-sm"
              role="status"
            >
              <span class="visually-hidden">Loading...</span>
            </div>
            Save
          </jet-button>
        </div>
      </div>
    </div>
  </div>
</template>