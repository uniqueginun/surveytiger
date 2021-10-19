<template>
    <form>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">{{ questiontext }}</div>
                <div class="card-body">
                    <slot />
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "PreviewCard",

    props: ['questiontext']
}
</script>
