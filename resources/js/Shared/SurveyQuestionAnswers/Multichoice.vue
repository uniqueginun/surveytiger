<script>
import JetInput from "@/Jetstream/Input.vue";
import { ref, watch, nextTick, toRefs } from "vue";

export default {
  components: {
    JetInput,
  },

  props: {
    payload: {
      default: null,
    },
  },

  emits: ["optionsChanged"],

  setup(props, { emit }) {
    const { payload } = toRefs(props);

    const intialOptions = payload?.value?.answers || [{ answer_text: "" }];

    const answers = ref(intialOptions);
    
    const inputRef = ref(null);

    const addOption = () => {
      answers.value.push({ answer_text: "" });
      nextTick(() => {
        /*let index = answers.value.length - 1;
        let input = inputRef.value[index];
        input.focus();*/
      });
    };

    const removeOption = (index) => {
      answers.value.splice(index, 1);
    };

    watch(answers.value, () => {
      emit("optionsChanged", answers.value);
    });

    return {
      answers,
      addOption,
      removeOption,
      payload,
    };
  },
};
</script>

<template>
  <div
    v-for="(item, index) of answers"
    :key="index"
    class="w-100 d-flex align-items-center mb-2"
  >
    <div class="w-50 mr-3">
      <jet-input
        v-model="item.answer_text"
        placeholder="Enter option"
        ref="inputRef"
        class="option"
        @keydown.enter="addOption"
      />
    </div>
    <div class="ml-3">
      <a v-on:click.prevent="addOption" class="btn btn-light mx-1" href="#">
        <i class="fas fa-plus text-dark"></i>
      </a>
      <a
        v-on:click.prevent="removeOption(index)"
        class="btn btn-light mx-1"
        href="#"
      >
        <i class="fas fa-minus text-dark"></i>
      </a>
    </div>
  </div>
</template>