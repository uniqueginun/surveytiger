<script>
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";

import { computed, ref, watch, toRefs } from "vue";

export default {
  components: {
    JetInput,
    JetLabel,
    JetCheckbox,
  },
  emits: ["optionsChanged"],
  props: {
    payload: {
      default: null,
    },
  },
  setup(props, { emit }) {
    const { payload } = toRefs(props);
    const oldLabels = payload?.value?.answers || null;

    const isNew = computed(() => {
      return !oldLabels;
    });

    const ratingScale = ref(payload?.value?.scale || 5);
    const hasLabels = ref(!isNew.value);

    const ratingScaleArray = computed(() => {
      const array = [];
      for (let i = 1; i <= ratingScale.value; i++) {
        array.push(i);
      }
      return array;
    });

    const triggerEmit = (labels = null) => {
      const options = labels || scaleLablesArray.value;
      let payload = [];
      payload["answers"] = hasLabels.value ? options : [];
      payload["scale"] = ratingScale.value;
      emit("optionsChanged", payload, "rating");
    };

    if (!isNew.value) {
      triggerEmit(oldLabels);
    }

    const scaleLablesArrayInitial = ratingScaleArray.value.map((i) => {
      let pos = i - 1;
      return {
        id: isNew.value || !oldLabels[pos] ? "" : oldLabels[pos].id,
        answer_text:
          isNew.value || !oldLabels[pos] ? `${i}` : oldLabels[pos].answer_text,
      };
    });

    const scaleLablesArray = ref(scaleLablesArrayInitial);

    watch(hasLabels, (has, _) => {
      has && triggerEmit();
    });

    watch(ratingScale, (count, old) => {
      if (parseInt(count) < parseInt(old)) {
        const filteredItems = scaleLablesArray.value.filter(
          (_, index) => index < count
        );
        scaleLablesArray.value = filteredItems;
      } else {
        scaleLablesArray.value.push({id: '', answer_text: `${count}`});
      }
      triggerEmit();
    });

    const answer_texts = computed(() => {
      return scaleLablesArray.value.map(item => item.answer_text);
    });

    watch(
      () => [...answer_texts.value],
      (texts, _) => {
        triggerEmit();
      }
    );

    return {
      ratingScale,
      hasLabels,
      ratingScaleArray,
      scaleLablesArray
    };
  },
};
</script>

<template>
  <div class="w-100 mb-3">
    <jet-label for="ratingScale" class="lables" value="Rating Scale (5 - 10)" />
    <jet-input type="number" v-model="ratingScale" :max="10" :min="5" :step="5" />
  </div>
  <div
    class="w-100 mb-4 d-flex flex-row align-items-center justify-content-start"
  >
    <jet-checkbox v-model="hasLabels" :checked="hasLabels" />
    <jet-label
      for="hasLabels"
      class="lables mt-1 mx-1"
      value="Enter rating labels"
    />
  </div>
  <template v-if="hasLabels">
    <div
      v-for="scale of ratingScaleArray"
      :key="scale"
      class="w-100 d-flex align-items-center mb-1"
    >
      <div class="w-50 mr-3">
        <jet-label
          for="hasLabels"
          class="lables mt-1 mx-1"
          :value="`Enter Label for scale (${scale})`"
        />
        <jet-input
          :placeholder="`Enter Label for scale (${scale})`"
          class="option"
          v-model="scaleLablesArray[scale - 1].answer_text"
        />
      </div>
    </div>
  </template>
</template>

<style scoped>
.lables {
  font-size: medium;
}
</style>