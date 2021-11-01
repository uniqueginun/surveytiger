<template>
  <div class="container-fluid p-4">
    <application-modal :show="showModal" title="Clone survey" @modal-hide="itemToClone = null" :hasfooter="false">
      <div v-if="itemToClone">
          <clone-survey :survey="itemToClone" :categories="categories"></clone-survey>
      </div>
    </application-modal>

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
              <a
                v-show="item.questions_count > 0"
                href="#"
                v-on:click.prevent="copy(item)"
                ><i class="fas fa-paper-plane text-success"></i
              ></a>
            </td>
            <td>
              <Link
                v-show="item.questions_count > 0"
                :href="route('surveys.preview-result', { survey: item })"
                ><i class="far fa-chart-bar"></i
              ></Link>
            </td>
            <td>
              <div class="btn-group">
                <button
                  id="moreOptions"
                  aria-expanded="false"
                  class="btn btn-success btn-sm text-white dropdown-toggle"
                  data-bs-toggle="dropdown"
                  type="button"
                >
                  More
                </button>
                <ul
                  aria-labelledby="moreOptions"
                  class="dropdown-menu dropdown-menu-dark"
                >
                  <li>
                    <Link
                      :data="{ survey: item }"
                      as="button"
                      class="dropdown-item"
                      :href="route('surveys.destroy', { survey: item })"
                      method="delete"
                      title="delete this survey"
                      type="button"
                    >
                      Delete <i class="far fa-trash-alt"></i>
                    </Link>
                  </li>
                  <li>
                    <a
                      v-show="item.questions_count > 0"
                      v-on:click.prevent="cloneSurvey(item)"
                      class="dropdown-item cursor-pointer"
                      title="make copy of this survey"
                      >Clone <i class="far fa-copy"></i
                    ></a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <tr v-show="surveys.length === 0">
            <td colspan="7">You haven't created any</td>
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
import ApplicationModal from "@/Shared/ApplicationModal.vue";
import CloneSurvey from '../Shared/CloneSurvey.vue';

export default {
  props: {
    surveys: {
      type: Array,
      default: [],
    },

    categories: {
        type: Array,
        default: [],
    }
  },

  data: () => ({
    itemToClone: null,
  }),

  components: {
    Grid,
    Link,
    ApplicationModal,
    CloneSurvey
  },

  computed: {
    showModal() {
      return this.itemToClone !== null;
    },
  },

  methods: {
    copy(item) {
      if (item.questions_count === 0) {
        toaster("No questions were added", "Error");
        return false;
      }

      copyUrl(route("survey.share", item));
    },

    cloneSurvey(item) {
      this.itemToClone = item;
    },
  },
};
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>