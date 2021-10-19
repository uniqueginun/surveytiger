<template>
    <div class="row justify-content-center mb-3">
        <survey-response-form @skipped="skip" @submitted="sendResponse" :canbeskipped="last" v-if="!preview">
            <template #title> {{ question.question_text }}</template>
            <draggable
                :component-data="{
                          tag: 'ul',
                          type: 'transition-group',
                          name: !drag ? 'flip-list' : null
                        }"
                :list="answers"
                class="list-group"
                item-key="id"
                tag="transition-group"
                v-bind="dragOptions"
                @end="drag=false"
                @start="drag=true"
            >
                <template #item="{element}">
                    <div class="list-group-item">{{ element.name }}</div>
                </template>
            </draggable>
        </survey-response-form>
        <preview-card v-else :questiontext="question.question_text">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item d-flex justify-content-between align-items-start" v-for="(item, index) of question.question_results" :key="index">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ item.answer_text }}</div>
                    </div>
                    <span class="badge bg-success rounded-pill">{{ item.answer_count }}</span>
                </li>
            </ol>
        </preview-card>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import {responseFormMixin} from "../../../Utils/minxin";
import PreviewCard from "../Previews/PreviewCard";

export default {
    name: "Ranking",

    mixins: [responseFormMixin],

    data() {
        return {
            drag: false,
            answers: []
        }
    },

    methods: {
        sendResponse() {
            this.$store.dispatch('setFormElement', {
                type: 'ranking',
                question_id: this.question.id,
                value: this.answers
            });
        }
    },

    created() {
        this.answers = this.question.answers.map((item) => ({id: item.id, name: item.answer_text}));
    },

    components: {
        PreviewCard,
        draggable
    },
    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
        }
    }
}
</script>

<style scoped>
.button {
    margin-top: 35px;
}

.flip-list-move {
    transition: transform 0.5s;
}

.no-move {
    transition: transform 0s;
}

.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.list-group {
    min-height: 20px;
}

.list-group-item {
    cursor: move;
}

.list-group-item i {
    cursor: pointer;
}
</style>
