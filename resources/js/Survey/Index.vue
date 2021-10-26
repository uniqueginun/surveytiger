<template>
  <div class="container-fluid p-4">
    <div class="row">
      <div class="col-md-12">
        <grid>
          <template v-slot:header>
            <tr>
              <th scope="col">Title</th>
              <th scope="col">Questions count</th>
              <th scope="col">Modified</th>
              <th scope="col">Design</th>
              <th scope="col">Collect</th>
              <th scope="col">Results</th>
              <th scope="col">More</th>
            </tr>
          </template>
          <tr v-for="item in surveys" :key="item.id">
            <td scope="row">{{ item.name }}</td>
            <td scope="row">{{ item.questions_count }}</td>
            <td>{{ item.updated_at }}</td>
            <td>
              <Link :href="route('surveys.design', item)"
                ><i class="fas fa-edit"></i
              ></Link>
            </td>
            <td>
              <a href="#" v-on:click.prevent="copy(item)"
                ><i class="fas fa-paper-plane text-success"></i
              ></a>
            </td>
            <td>
              <Link :href="route('surveys.preview-result', { survey: item })"
                ><i class="far fa-chart-bar"></i
              ></Link>
            </td>
            <td>
              <div class="btn-group">
                <button
                  class="btn btn-success btn-sm text-white dropdown-toggle"
                  type="button"
                  id="moreOptions"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  More
                </button>
                <ul class="dropdown-menu" aria-labelledby="moreOptions">
                  <li><a class="dropdown-item" href="#">Delete</a></li>
                  <li><a class="dropdown-item" href="#">Duplicate</a></li>
                </ul>
              </div>
            </td>
          </tr>
          <tr v-show="surveys.length === 0">
            <td colspan="6">You havn't created any</td>
          </tr>
        </grid>
      </div>
    </div>
  </div>
</template>

<script>
import Grid from "@/Shared/Grid.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { copyUrl } from "../Utils";

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

  methods: {
    copy(item) {
      copyUrl(route("survey.share", item));
    },
  },
};
</script>
