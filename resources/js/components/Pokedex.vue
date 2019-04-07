<template>
	<div class="pokedex">
		<h1>Pokedex</h1>
		<div class="pokemon-list container">
			<div class="row">
				<div class="col">
					<input type="text" placeholder="Search" v-model="pokedexSearch" autofocus>
					<div class="list-wrap">
						<ul>
							<li @click="setPokemonData(monster)" v-for="monster in filteredPokemon" :key="monster.pokemon_id">
								<div>
									<span>#{{monster.pokemon_id}}</span>
									<lazy-image :lazy-src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${monster.pokemon_id}.png`" />
									<span>{{monster.name}}</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="col">
					<div class="pokemon-detail">
						<div v-if="pokemonData.id" class="info" :key="pokemonData.id">
							<div v-if="pokemonData.generation" class="generation">
								<span>
									{{ formatGeneration(pokemonData.generation) }}
								</span>
							</div>
							<lazy-image :lazy-src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${pokemonData.pokemon_id}.png`" />
							<h2>{{pokemonData.name}}</h2>
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
			</div>

		</div>
	</div>
</template>


<script>
export default {
	props: {
		pokemon: Array,
	},

	data: function() {
		return {
			pokemonData: {},
			pokedexSearch: '',
		}
	},

	computed: {
		filteredPokemon: function() {
			if (this.pokemon) {
				return this.pokemon.filter(pokemon => {
					return pokemon.name.includes(this.pokedexSearch.toLowerCase());
				});
			}
		}
	},

	methods: {
		setPokemonData: function(pokemon) {
			this.pokemonData = pokemon;
			if (pokemon.generation == null) {
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
		formatGeneration: function(string) {
			return string.split('generation-')[1];
		}
	},
}
</script>

<style lang="scss">
.pokedex {
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	background: tomato;
	color: #FFF;

	.pokemon-list {
		height: 75vh;
		background: rgba(0,0,0,.5);

		.row {
			height: 100%;
		}

		.col {
			height: 100%;
			display: flex;
			flex-direction: column;
			overflow: hidden;

			input {
				background: transparent;
				font: inherit;
				color: #FFF;
				border: 0;
				border-bottom: 2px solid #FFF;
				outline: none;
				font-size: 1.5em;
				padding: .5em 0;

				&::placeholder {
					color: rgba(255,255,255,.5);
				}
			}
		}

		.list-wrap {
			flex: 1 1 auto;
			overflow-y: auto;

			ul {
				margin: 0;
				padding: 0;
				list-style: none;
				border-radius: 4px;

				li {
					padding: 0;

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

					div {
						display: flex;
						padding: .25em 0;
						align-items: center;
					}

					span {
						&:first-child {
							width: 4em;
							text-align: right;
						}

						&:last-child {
							width: 12em;
							text-transform: uppercase;
						}
					}

					img {
						width: 3em;
						height: 3em;
						object-fit: contain;
						margin: 0 1em;
						image-rendering: pixelated;
					}
				}
			}
		}


		.pokemon-detail {
			padding: 2em 0;

			.generation {
				position: absolute;
				top: 0;
				right: 0;
				padding: 1em;
				text-transform: uppercase;
				font-family: "Times New Roman";

				span {
					position: absolute;
					right: 1em;
					z-index: 1;
				}

				&:before {
					content: '';
					width: 8em;
					height: 8em;
					background: #000;
					transform: rotate(45deg);
					position: absolute;
					top: -200%;
					right: -200%;
					z-index: 0;
				}
			}

			img {
				width: 100%;
				height: 300px;
				object-fit: contain;
				image-rendering: pixelated;
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
	}
}
</style>
