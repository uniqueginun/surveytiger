<template>
    <div id="offcanvasBottom" aria-labelledby="offcanvasScrollingLabel"
         class="offcanvas offcanvas-bottom bg-success text-white"
         data-bs-backdrop="false" data-bs-scroll="true" tabindex="-1">
        <div class="d-flex justify-content-center align-items-center offcanvas-body text-center">
            <div class="d-flex justify-content-center align-items-center w-25">
                <span>{{ answered }} of {{ total }} answered</span>
                <div class="progress flex-1 mx-3">
                    <div aria-valuemax="100" aria-valuemin="0" :aria-valuenow="percentage" :class="classList" role="progressbar" :style="style">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OffcanvasBottom",

    computed: {
        total() {
            return this.$store.getters.questions.length
        },

        answered() {
            return this.$store.getters.answered
        },

        percentage() {
            const perc = (this.answered / this.total) * 100;
            return parseInt(perc);
        },

        classList() {
            return 'progress-bar progress-bar-striped progress-bar-animated';
        },

        style() {
            return `width: ${this.percentage}%`;
        }
    },

    mounted() {
        var myOffcanvas = document.getElementById('offcanvasBottom')
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
        bsOffcanvas.show();
    }
}
</script>

<style scoped>

</style>
