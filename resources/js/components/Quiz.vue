<template>
	<div class="quiz">
		<h1>Who's that Pokemon!?</h1>

		<div v-if="randomPokemon" :class="{'pokemon-clue': true, 'success': isGuessCorrect}">
			<img :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${randomPokemon.pokemon_id}.png`" alt="">

			<div class="pokemon-info">
				<div v-if="isGuessCorrect" class="pokemon-info-data">
					<h2>It's {{ pokemonData.name }}!</h2>
					<ul>
						<li v-for="type in pokemonData.types" :key="type.id" :class="`type type-${type.name}`">
							{{ type.name }}
						</li>
					</ul>
					<p>{{ pokemonData.genus }}</p>
					<p>{{ pokemonData.flavor_text }}</p>
				</div>
			</div>
		</div>

		<div  v-if="!isGuessCorrect" class="guess-input">
			<ul v-if="guess && !isGuessCorrect" class="guess-list">
				<li v-for="pokemon in guessList" @click="guess = pokemon.name" :key="pokemon.id">
					<div>
						<img :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${pokemon.pokemon_id}.png`" alt="">
						{{pokemon.name}}
					</div>
				</li>
			</ul>
			<input type="text" v-model="guess"  autofocus :disabled="isGuessCorrect">
		</div>
		<button v-else @click="setNewRandomNumber">Play again</button>
	</div>
</template>


<script>
    export default {
		props: {
			pokemon: Array,
		},

		data: function() {
			return {
				guess: '',
				pokemonData: {},
				randomNumber: 0,
			}
		},

		computed: {
			randomPokemon: function() {
				if (this.randomNumber != 0) {
					return this.pokemon[this.randomNumber];
				}
			},

			guessList: function() {
				if (this.guess != '') {
					return this.pokemon.filter(pokemon => {
						return pokemon.name.includes(this.guess);
					}).slice(0, 10);
				}
			},

			isGuessCorrect: function() {
				if (this.randomPokemon && this.guess != '') {
					return this.randomPokemon.name == this.guess.toLowerCase();
				}
			}
		},

		watch: {
			pokemon: function(array) {
				this.setNewRandomNumber();
			},

			isGuessCorrect: function(value) {
				if (value) {
					if (this.randomPokemon.generation == null) {
						this.getPokemonData;
					}
				}
			},

			randomPokemon: function(pokemon) {
				if (pokemon) {
					this.setPokemonData(pokemon);
				}
			},
		},

        mounted() {
			this.setNewRandomNumber();
			document.querySelector('.guess-input input').focus();
		},

		methods: {
			setPokemonData: function(pokemon) {
				if (pokemon.generation != null) {
					this.pokemonData = pokemon;
				} else {
					this.getPokemonData(pokemon.pokemon_id);
				}
			},
			getPokemonData: function(id) {
				axios.get(`/api/pokemon/${id}`)
				.then(res => {
					this.pokemonData = res.data;
				})
				.catch(error => console.error(error));
			},
			setNewRandomNumber: function() {
				this.guess = '';
				if(this.pokemon) {
					this.randomNumber = Math.floor(Math.random() * this.pokemon.length);
				}
				setTimeout(function() {
					document.querySelector('.guess-input input').focus();
				}, 500);
			}
		}
    }
</script>

<style lang="scss">
.quiz {
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-direction: column;
	background: tomato;
	color: #FFF;
	padding: 2em 0;

	h1 {
		font-size: 4em;
	}

	.pokemon-clue {
		display: flex;
		transition: background .5s;
		border-radius: 4px;

		img {
			height: 400px;
			width: 400px;
			object-fit: contain;
			filter: brightness(0);
			image-rendering: pixelated;
			transition: filter .5s;
		}

		.pokemon-info {
			width: 0;
			display: flex;
			flex-direction: column;
			justify-content: center;
			overflow: hidden;
			transition: width .5s;

			&-data {
				width: 400px;
				padding: 2em;
			}

			h2 {
				text-transform: uppercase;
				font-size: 3em;

			}

			ul {
				display: flex;
				list-style: none;
				margin: 0;
				margin-bottom: 1em;
				padding: 0;
				text-transform: uppercase;

				+ p {
					opacity: .5;
				}
			}
		}

		&.success {
			background: rgba(0,0,0,0.5);

			img {
				filter: brightness(1);
			}

			.pokemon-info {
				width: 400px;
			}
		}
	}

	.guess-input {
		position: relative;
		transition: opacity .5s;
		height: 4em;

		&.success {
			opacity: 0;
		}

		input {
			background: transparent;
			border: 0;
			font: inherit;
			border-bottom: 2px solid #FFF;
			width: 400px;
			padding: .25em 0;
			color: #FFF;
			font-size: 2em;
			text-align: center;
			outline: none;
			text-transform: uppercase;
			transition: border-bottom .5s;
		}

		.guess-list {
			position: absolute;
			bottom: 100%;
			width: 100%;
			background: rgba(0,0,0,0.5);
			margin: 0;
			padding: .25em 0;
			list-style: none;
			font-size: 1.5em;
			text-transform: uppercase;
			border-radius: 4px;

			li {
				padding: 0 1em .25em;

				&:hover {
					background: rgba(0,0,0,.25);
					cursor: pointer;
				}

				&:before {
					width: 100%;
					height: 1px;
					background: rgba(255,255,255,.5);
					content: '';
					display: block;
					margin-bottom: .25em;
				}

				&:first-child {
					padding-top: .25em;

					&:before {
						content: none;
					}
				}

				> div {
					display: flex;
					align-items: center;
				}

				img {
					height: 2em;
					width: 2em;
					object-fit: contain;
					image-rendering: pixelated;
					margin-right: 1em;
				}
			}
		}
	}

	button {
		background: rgba(0,0,0,.5);
		border: 0;
		font: inherit;
		color: #FFF;
		font-size: 2em;
		padding: .25em 1em;
	}
}
</style>
