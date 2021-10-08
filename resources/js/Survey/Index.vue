<template>
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-md-12">
        <grid>
          <template v-slot:header>
            <tr>
              <th scope="col">Title</th>
              <th scope="col">Modified</th>
              <th scope="col">Design</th>
              <th scope="col">Collect</th>
              <th scope="col">Analyze</th>
              <th scope="col">More</th>
            </tr>
          </template>
          <tr v-for="item in surveys" :key="item.id">
            <td scope="row">{{ item.name }}</td>
            <td>{{ item.updated_at }}</td>
            <td>
              <Link
                :href="route('surveys.design', item)"
                class="btn btn-success text-light"
                >Design</Link
              >
            </td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr v-show="surveys.length === 0">
            <td colspan="6">No data found</td>
          </tr>
        </grid>
      </div>
    </div>
  </div>
</template>

<script>
import Grid from "@/Shared/Grid.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    surveys: {
      type: Array,
      default: [],
    },
  },
  components: {
    Grid,
    Link,
  },
};
</script>