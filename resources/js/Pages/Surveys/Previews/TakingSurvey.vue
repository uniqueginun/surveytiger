<template>
    <div>
        <div class="container fixed-top mt-5">
            <div class="col-10">
                <h4 class="text-success fw-bolder">{{ survey.name }}</h4>
            </div>
            <div class="col-10">
                <preview-questions :types="types" :survey="survey"></preview-questions>
            </div>
        </div>

        <offcanvas-bottom></offcanvas-bottom>
    </div>
</template>

<script>
import PreviewQuestions from "../Partials/PreviewQuestions";
import OffcanvasBottom from "../Previews/OffcanvasBottom";

export default {
    name: "TakingSurvey",

    props: ['survey', 'types'],

    components: {OffcanvasBottom, PreviewQuestions},
}
</script>

<style scoped>
.offcanvas-bottom {
    height: 7vh !important;
}
</style>
