<template>
  <Link :href="route('home')"><img src="/images/tiger.png" :width="width" /></Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    width: {
      type: String,
      default: 80
    }
  },
  components: {
    Link,
  },
};
</script>