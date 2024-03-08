<script setup lang="ts">
import { theme } from '#tailwind-config'

interface Props {
	variant?: 'outlined' | 'filled' | 'border'
}

withDefaults(defineProps<Props>(), {
	variant: 'filled'
})

const getColorValue = (colorName: string) => {
	const [color, shade] = colorName.split('-')
	return shade ? 
		(theme.colors as any)[color][shade] : 
		(theme.colors as any)[color]
}

const squares = [
	'primary-50',
	'primary-DEFAULT',
	'accent',
	'secondary-DEFAULT'
].map(getColorValue)
</script>

<template>
  <div class="flex gap-4">
    <div
      v-for="square in squares"
      :key="square"
      :class="[variant, '!border-2 w-5 h-5']"
      :style="{ 
        backgroundColor: square,
        borderColor: square
      }"
    />
  </div>
</template>

<style scoped lang="postcss">
.filled {
	@apply !border-none;	
}

.border {
	@apply !border-white;
}

.outlined {
	@apply !bg-[transparent];
}
</style>
