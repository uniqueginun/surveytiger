<template>
  <li class="nav-item">
    <Link :href="href" :class="classes" :style="active ? 'color: #fff !important' : ''">
      <slot></slot>
    </Link>
  </li>
</template>

<script>
  import { defineComponent } from 'vue'
  import { Link } from '@inertiajs/inertia-vue3'

  export default defineComponent({
    components: {
      Link,
    },
    
    props: ['href', 'active'],

    computed: {
      classes() {
        return this.active
            ? 'nav-link active font-weight-bolder text-uppercase'
            : 'nav-link text-uppercase'
      }
    }
  })
</script>
