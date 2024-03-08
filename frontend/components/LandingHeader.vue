<script setup lang="ts">

</script>

<template>
  <header class="h-20 p-4 fixed w-full top-0 flex items-center justify-between z-[100] bg-white">
    <!-- TODO: componentize -->
    <RouterLink
      to="/"
      class="text-2xl font-thin underline decoration-primary px-5 text-secondary-50"
    >
      <!-- TODO: get it from somwhere -->
      fiatlinux.it
    </RouterLink>

    <div class="flex gap-5 px-5">
      <MainButton to="/login">
        Accedi
      </MainButton>

      <MainButton
        to="/register"
        variant="text"
      >
        Registrati
      </MainButton>
    </div>
  </header>
</template>

