<template>
  <div class="table-responsive-sm">
    <table class="table table-hover">
      <thead class="thead-light text-white">
        <slot name="header"></slot>
      </thead>
      <tbody>
        <slot></slot>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
thead {
  background-image: linear-gradient(
    to right,
    rgb(54 95 151) 0%,
    rgb(133 149 177) 100%
  );
}
</style>
