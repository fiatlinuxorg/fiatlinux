export default defineNuxtConfig({
	devtools: { enabled: true },
	modules: [
		'@nuxtjs/tailwindcss',
		'@nuxtjs/google-fonts',
	],	
	tailwindcss:{
		exposeConfig: true,
	},
	googleFonts: {
		families: {
			Figtree: true,
		}
	}
})
