<template>
  <jet-form-section @submitted="updateSurveyInformation">
    <template #title> Survey's Information </template>

    <template #description>
      You can edit your survey's basic information.
    </template>

    <template #form>
      <jet-action-message :on="form.recentlySuccessful">
        Saved.
      </jet-action-message>

      <div @mouseenter="handleMouseEvent('enter')" @mouseleave="handleMouseEvent('out')">
        <h4 v-if="!enableEdit" class="d-flex justify-content-between align-items-center p-3" :class="{'bg-light': showEditButton}">
          <span>{{ survey.name }}</span>
          <a @click="enableEdit = true" v-if="showEditButton" type="button">
            <i class="fas fa-pencil text-dark"></i>
          </a>
        </h4>
        <h4 v-if="enableEdit" class="d-flex justify-content-end align-items-center">
          <a type="button" @click="enableEdit = false"> <i class="fas fa-times text-danger"></i> </a>
        </h4>
        <div v-if="enableEdit" class="w-75">
          <!-- Title -->
          <div class="mb-3">
            <jet-label for="name" value="Title" />
            <jet-input
              id="name"
              type="text"
              v-model="form.name"
              :class="{ 'is-invalid': form.errors.name }"
              autocomplete="name"
            />
            <jet-input-error :message="form.errors.name" />
          </div>
          <div class="mb-3">
            <jet-label for="category" value="Category" />
            <select
              id="category"
              class="form-select"
              v-model="form.category_id"
            >
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
    </template>

    <template #actions>
      <div v-if="enableEdit">
      <jet-button
        :class="{ 'text-white-50': form.processing }"
        :disabled="form.processing"
      >
        <div
          v-show="form.processing"
          class="spinner-border spinner-border-sm"
          role="status"
        >
          <span class="visually-hidden">Loading...</span>
        </div>

        Save
      </jet-button>
      </div>
    </template>
  </jet-form-section>
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

  props: ["survey", "categories"],

  data() {
    return {
      form: this.$inertia.form({
        _method: "PUT",
        name: this.survey.name,
        category_id: this.survey.category_id,
        description: this.survey.description,
      }),
      enableEdit: false,
      showEditButton: false
    };
  },

  methods: {
    updateSurveyInformation() {
      this.form.post(route("surveys.update", this.survey.id), {
        errorBag: "updateSurveyInformation",
        preserveScroll: true,
        onSuccess: () => {
          this.enableEdit = false;
        },
      });
    },
    handleMouseEvent(action) {
      this.showEditButton = (action === "enter");
    }
  },
});
</script>