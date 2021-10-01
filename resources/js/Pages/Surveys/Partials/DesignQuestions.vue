<template>
  <div>
    <div class="row mb-3">
      <div class="col-md-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="w-100 d-flex align-items-center">
              <div class="w-75">
                <jet-input
                  id="question"
                  type="text"
                  placeholder="Question"
                  autocomplete="question"
                />
              </div>
              <div class="mx-2">
                <select
                  id="type"
                  class="form-select"
                >
                  <option value="">choose one ...</option>                 
                  <option value="">choose one ...</option>                 
                  <option value="">choose one ...</option>                 
                </select>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-end"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

export default defineComponent({
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },

  props: ["survey"],

  data() {
    return {
      questions: [],
    };
  },

  methods: {},
});
</script>