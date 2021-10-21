<template>
    <div class="container-fluid">

        <div class="offcanvas offcanvas-top bg-indigo text-white text-center" tabindex="-1" id="offcanvasTop" data-bs-scroll="true" data-bs-backdrop="false" aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body text-center">
                <h4>Thank you for taking this survey</h4>
            </div>
        </div>

        <div class="container d-flex align-items-center justify-content-center">
            <div class="row justify-content-center">
                <div class="col-12">
                    Create and edit your own survey, create account now
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "ThankYouForTaking.vue",

    mounted() {
        var myOffcanvas = document.getElementById('offcanvasTop')
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
        bsOffcanvas.show();
    }
}
</script>

<style scoped>
.offcanvas-top {
    height: 15vh !important;
}
</style>
