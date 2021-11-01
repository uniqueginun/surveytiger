import { ref } from 'vue';
import { handleError, handleSuccess } from '@/Utils/index.js';
import { Inertia } from '@inertiajs/inertia';

export const useAnswers = (surveyId, questionId) => {
   const answers = ref([]);
   const questionSurvey = ref(null);

   const url = `/api/survey/${surveyId}/question/${questionId}/answers`;

   const loadAnswers = async () => {
      const { data } = await axios.get(url);
      answers.value = data.offeredAnswers;
      questionSurvey.value = data.questionSurvey;
   };

   return {
      answers,
      questionSurvey,
      loadAnswers,
   };
}

export const useDeleteQuestion = (surveyId, questionId) => {

   const isDeleting = ref(false);

   const payload = { survey: surveyId, question: questionId };

   const deleteQuestion = async () => {

      isDeleting.value = true;

      Inertia.delete(route('surveys.question.delete', payload), {
         preserveScroll: true,
         onError: (error) => handleError(error),
         onSuccess: ({ props }) => {
            handleSuccess(props.jetstream.flash.message);
         },
         always: () => isDeleting.value = false,
      });
   }

   return {
      isDeleting,
      deleteQuestion,
   };
}

export const useUpdateQuestion = (surveyId, questionId) => {
   const isUpdating = ref(false);
   const editingMode = ref(false);

   const toggleEditing = () => {
      editingMode.value = !editingMode.value;
   }

   const updateQuestion = (data) => {
      isUpdating.value = true;
      Inertia.put(route('surveys.question.update', { survey: surveyId, question: questionId }), data, {
         preserveScroll: true,
         onError: (error) => handleError(error),
         onSuccess: () => {
            handleSuccess('Question edited successfully');
         },
         onFinish: () => isUpdating.value = false,
      });
   }

   return {
      isUpdating,
      toggleEditing,
      editingMode,
      updateQuestion
   };
}