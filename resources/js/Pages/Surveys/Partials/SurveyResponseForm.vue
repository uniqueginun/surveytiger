<template>
    <form v-on:submit.prevent="$emit('submitted')">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <slot name="title"></slot>
                </div>
                <div class="card-body">
                    <slot></slot>
                </div>
                <div class="card-footer text-right">
                    <button v-show="!isLast" class="btn btn-outline-secondary btn-sm" type="button"
                            v-on:click="$emit('skipped')">Skip question
                    </button>
                    <button :class="{'mx-3': !isLast }" class="btn btn-outline-success btn-sm" type="submit">
                        {{ isLast ? "Send your response" : "Next" }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "SurveyResponseForm.vue",

    emits: ['submitted', 'skipped'],

    props: ['canbeskipped'],

    computed: {
        isLast() {
            return this.canbeskipped
        }
    }
}
</script>

