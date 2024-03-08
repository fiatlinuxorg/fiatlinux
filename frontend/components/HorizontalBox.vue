<script setup lang="ts">
</script>

<template>
  <div>
    <div class="flex flex-col items-center justify-between h-1/2 w-full px-10 sm:flex-row">
      <div class="w-full sm:w-1/2">
        <slot name="left" />
      </div>
      <div class="w-full sm:w-1/2 flex-center">
        <slot name="right" />
      </div>
    </div>
  </div>
</template>

