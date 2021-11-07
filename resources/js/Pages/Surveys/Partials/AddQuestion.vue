<script>
import JetInput from "@/Jetstream/Input.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import Multichoice from "@/Shared/SurveyQuestionAnswers/Multichoice.vue";
import Slider from "@/Shared/SurveyQuestionAnswers/Slider.vue";
import Rating from "@/Shared/SurveyQuestionAnswers/Rating.vue";
import { reactive, computed, toRefs, watch, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useUpdateQuestion } from "@/Composable/SurveyQuestionAnswer.js";

export default {
  components: {
    JetInput,
    JetButton,
    JetInputError,
    Multichoice,
    Rating,
    Slider,
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
    questionSurvey: {
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
      questionSurvey,
      updating,
    } = props;

    const QuestionForm = reactive({
      question_text: question_text,
      question_type_id: question_type_id,
      answers: answers,
      scale: questionSurvey?.scale,
      min: questionSurvey?.min,
      max: questionSurvey?.max,
      center: questionSurvey?.center,
    });

    const formErrors = reactive({});

    const processing = ref(false);

    const answersBLock = computed(() => {
      const type = questiontypes.find(
        (questiontype) => questiontype.id == QuestionForm.question_type_id
      );

      if (!type || !type.has_options) {
        return null;
      }

      return type.component_name;
    });

    const optionsChanged = (options, source = null) => {
      if (source && source === "rating") {
        QuestionForm.answers = options["answers"];
        QuestionForm.scale = options["scale"];
      } else if (source && source === "slider") {
        QuestionForm.center = options["center"];
        QuestionForm.min = options["min"];
        QuestionForm.max = options["max"];
      } else {
        QuestionForm.answers = options;
      }
    };

    const { isUpdating, updateQuestion } = useUpdateQuestion(
      props.survey.id,
      updating
    );

    watch(isUpdating, (status, _) => {
      !status && emit("questionUpdated");
    });

    const saveQuestion = () => {
      if (updating) {
        updateQuestion(QuestionForm);
        return;
      }

      processing.value = true;

      Inertia.post(route("surveys.design", props.survey.id), QuestionForm, {
        preserveScroll: true,
        onSuccess: () => {
          toaster("question was successfully added.");
          QuestionForm.question_text = question_text;
          QuestionForm.question_type_id = question_type_id;
          QuestionForm.answers = answers;
        },
        onError: (errors) => {
          formErrors.value = errors;
          toaster(errors.message, "Error", "danger", "red");
        },
        onFinish: () => processing.value = false
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
      processing
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
            :payload="QuestionForm"
            @optionsChanged="optionsChanged"
          ></component>
        </div>
        <div class="card-footer d-flex justify-content-end">
          <slot name="closeEdit" />
          <jet-button @click.prevent="saveQuestion" :disabled="processing">
            <div
              v-show="processing"
              class="spinner-border spinner-border-sm"
              role="status"
            >
              <span class="visually-hidden">Loading...</span>
            </div>
            {{ processing ? 'Saving...' : 'Save' }}
          </jet-button>
        </div>
      </div>
    </div>
  </div>
</template>