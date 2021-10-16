<template>
    <div class="container d-flex py-3 bg-white shadow-sm border-bottom mb-5">
        <nav aria-label="breadcrumb" class="survey-nav">
            <ol class="breadcrumb">
                <li
                    v-for="(item, index) in crumbs"
                    :key="index"
                    :class="{ active: activeCrumb === item.name }"
                    aria-current="page"
                    class="breadcrumb-item"
                >
                    <a :href="item.link" v-on:click.prevent="crumbClick(item)">
                        {{
                            item.name
                        }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    name: "SurveyCrumb",
    props: ["activeCrumb"],
    data: () => ({
        crumbs: [
            {
                name: "Survey design",
                link: "#",
            },
            {
                name: "Preview and score",
                link: "#",
            },
        ],
    }),
    methods: {
        crumbClick(crumb) {
            this.$emit("changed", crumb.name);
        },
    },
});
</script>

<style scoped>
.survey-nav {
    --bs-breadcrumb-divider: '>';
}

ol.breadcrumb {
    padding-bottom: 0px !important;
}

.breadcrumb-item a {
    text-decoration: none !important;
    color: #6c757d;
}

.breadcrumb-item.active a {
    color: #38c172;
    font-weight: bold;
}
</style>
