<script>
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { ref, watch, toRefs } from "vue";

export default {
  components: {
    JetInput,
    JetLabel,
  },

  props: {
    payload: {
      default: null,
    },
  },

  emits: ["optionsChanged"],

  setup(props, { emit }) {
    const { payload } = toRefs(props);

    const initial = {
      min: payload?.value?.min || 0,
      max: payload?.value?.max || 4,
      center: payload?.value?.center || 10,
    };

    const answers = ref(initial);

    watch(answers.value, () => {
      emit("optionsChanged", answers.value, "slider");
    });

    return {
      answers,
      payload,
    };
  },
};
</script>

<template>
  <div class="w-100 d-flex align-items-center mb-2">
    <div class="w-25 mr-3">
      <jet-label>Left side</jet-label>
      <jet-input class="option" type="number" min="0" max="100" v-model="answers.min" />
    </div>
    <div class="w-25 mr-3">
      <jet-label>Center</jet-label>
      <jet-input class="option" type="number" min="0" max="100" v-model="answers.center" />
    </div>
    <div class="w-25 mr-3">
      <jet-label>Right side</jet-label>
      <jet-input class="option" type="number" min="10" max="100" v-model="answers.max" />
    </div>
  </div>
</template>

<style scoped>
.mr-3 {
  margin-right: 1rem;
}
</style>