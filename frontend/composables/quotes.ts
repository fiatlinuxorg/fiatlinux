import randomQuotes from '@/assets/quotes.json'

export function useQuotes(changeSpeed = 10) {
	const quote = ref('')
	const author = ref('')
	const isChanging = ref(false)

	const noise = 'Abcdefghijklmnopqrstuvwxyz[]{}|;:.,<>?/!@#$%^&*()_+1234567890'

	// TODO: animation duration should be the same for all strings
	async function randomize(from: Ref<string>, to: string) {	
		while (from.value.length !== to.length) {
			const _from = [...from.value]
			const index = Math.floor(Math.random() * from.value.length)
			const random = noise[Math.floor(Math.random() * noise.length)]
			_from[index] = random

			from.value = _from.join('')

			from.value.length < to.length ?
				from.value += random :
				from.value = from.value.slice(0, -1)

			await new Promise(resolve => setTimeout(resolve, changeSpeed))
		}

		const generatedIndexes = new Set()
		while (from.value !== to) {
			const _from = [...from.value]
    
			let index
			do {
				index = Math.floor(Math.random() * from.value.length)
			} while (generatedIndexes.has(index))
			generatedIndexes.add(index)

			_from[index] = to[index]

			from.value = _from.join('')
			await new Promise(resolve => setTimeout(resolve, changeSpeed))
		}

		generatedIndexes.clear()
	}

	function randomQuote() {
		return randomQuotes[Math.floor(Math.random() * randomQuotes.length)]
	}

	function getRandomQuote() {
		const { quote: _quote, author: _author } = randomQuote()

		quote.value = _quote
		author.value = _author
	}

	async function getRandomQuoteWithNoise() {
		if (isChanging.value) return
		isChanging.value = true

		const { quote: _quote, author: _author } = randomQuote()

		await Promise.all([
			randomize(quote, _quote),
			randomize(author, _author)
		])	

		isChanging.value = false
	}

	return {
		quote: readonly(quote),
		author: readonly(author),
		getRandomQuote,
		getRandomQuoteWithNoise,
		randomize,
		isChanging
	}
}
