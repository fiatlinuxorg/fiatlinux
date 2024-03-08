<script setup lang="ts">
export interface Props {
	variant?: 'filled' | 'text'
	to?: string
}

withDefaults(defineProps<Props>(), {
	variant: 'filled',
	to: undefined
})
</script>

<template>
  <!-- TODO: fix 48 px height instead of 43 -->
  <component
    :is="to ? 'RouterLink' : 'button'"
    :to="to"
    :class="['p-3 inline-block', variant]"
  >
    <slot />
  </component>
</template>


<style scoped lang="postcss">
.filled {
	@apply text-white bg-primary hover:bg-accent 
		transition duration-200 ease-in-out
		ease-[cubic-bezier(.4,0,.2,1)];
}

.text {
	@apply text-secondary;

	/*TODO: make it relative to secondary color */
	&:hover {
		@apply text-gray-700;
	}
}
</style>
