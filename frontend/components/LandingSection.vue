<script setup lang="ts">
</script>

<template>
  <div class="flex flex-col items-center justify-center h-screen">
    <HorizontalBox>
      <template #left>
        <h3 class="underline decoration-primary text-2xl font-bold text-secondary sm:text-3xl md:text-4xl lg:text-5xl">
          Made in FIAT LinUX!
        </h3>

        <p class="text-md font-thin sm:text-lg md:text-xl lg:text-2xl text-gray-600 my-4">
          Raga ho scoperto che Furnò nei vecchi salvataggi scriveva FIAT LUX, 
          che tradotto dal latino significa "<span class="text-accent">Sia fatta la luce</span>".
          Ma quanto è un genio??? (sono malato) In più il nuovo sito è una figata assurda.
        </p>
      </template>

      <template #right>
        <img
          class="object-cover h-full w-1/2"
          src="@/assets/images/logo.svg"
          alt="logo"
        >
      </template>
    </HorizontalBox>
  </div>
</template>

