<template>
    <div class="table-responsive-sm">
        <table class="table table-hover">
            <thead class="thead-light">
            <slot name="header"></slot>
            </thead>
            <tbody>
            <slot></slot>
            </tbody>
        </table>
    </div>
</template>
