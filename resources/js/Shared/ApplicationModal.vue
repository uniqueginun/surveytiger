<template>
  <div
    class="modal fade"
    :id="identifier"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" :class="sizeClass">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticModalLabel">{{ title }}</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <slot></slot>
        </div>
        <div class="modal-footer" v-show="hasfooter">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    identifier: {
      type: String,
      default: "application-modal",
    },

    show: {
      type: Boolean,
      default: false,
    },

    size: {
      type: String,
      default: "xl",
    },

    title: {
      type: String,
      default: "modal title",
    },

    hasfooter: {
      type: Boolean,
      default: true,
    }
  },

  watch: {
    show(value) {
      if (value) {
        this.modalElement.show();
      } else {
        this.modalElement.hide();
      }
    },
  },

  computed: {
    modal() {
      return document.getElementById(this.identifier);
    },
    modalElement() {
      return new bootstrap.Modal(this.modal);
    },

    sizeClass() {
      return `modal-${this.size}`;
    },
  },

  mounted() {
    this.modal.addEventListener("hidden.bs.modal", () => {
      this.$emit("modal-hide");
    });
  },
};
</script>