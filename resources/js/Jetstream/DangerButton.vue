<template>
  <button :type="type" class="btn btn-danger text-uppercase" :class="[dark ? 'text-dark' : 'text-white']">
    <slot></slot>
  </button>
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
  props: {
      type: {
        type: String,
        default: 'button',
      },
      dark: {
        type: Boolean,
        default: false,
      }
    }
  })
</script>
