<script setup lang="ts">
interface Props {
	changeInterval?: number
}

const { changeInterval }= withDefaults(defineProps<Props>(), {
	changeInterval: 3000
})

const { quote, getRandomQuoteWithNoise, author, getRandomQuote, isChanging } = useQuotes()

onMounted(() => {
	getRandomQuote()

	// TODO: fix this horror
	setInterval(async () => {
		getRandomQuoteWithNoise()

		if (!isChanging.value)
			await new Promise(resolve => setTimeout(resolve, changeInterval))

	}, changeInterval)
})
	
</script>

<template>
  <div class="p-6 flex flex-col items-start justify-start w-full max-w-screen-xl h-1/3">
    <div class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-7xl p-4 w-full bg-secondary">
      {{ quote }}
    </div>

    <div class="text-white text-xl p-4 w-10/12 bg-accent">
      {{ author }}
    </div>

    <div class="text-white text-xl sm:text-4xl md:text-5xl lg:text-7xl p-7 w-3/4 bg-primary" />
    <div class="text-white text-xl sm:text-4xl md:text-5xl lg:text-7xl p-7 w-2/3 bg-primary-50" />
  </div>
</template>

