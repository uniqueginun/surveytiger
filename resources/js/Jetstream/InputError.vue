<template>
  <div v-show="message" class="invalid-feedback fs-6" role="alert">
    <strong>{{ message }}</strong>
  </div>
</template>

<script>
  import { defineComponent } from 'vue'

  export default defineComponent({
    props: ['message']
  })
</script>
