<template>
	<div class="pokedex">
		<h1>Pokedex</h1>
		<div class="pokemon-list">
			<ul>
				<li @click="setPokemonData(monster)" v-for="monster in pokemon" :key="monster.pokemon_id">
					<div>
						<span>#{{monster.pokemon_id}}</span>
						<img :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${monster.pokemon_id}.png`" alt="">
						<span>{{monster.name}}</span>
					</div>
				</li>
			</ul>

			<div class="pokemon-detail">
				<div v-if="pokemonData" class="info" :key="pokemonData.id">
					<img :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${pokemonData.pokemon_id}.png`" alt="">
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
</template>


<script>
export default {
	props: {
		pokemon: Array,
	},

	data: function() {
		return {
			pokemonData: {},
		}
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
		display: flex;
		background: rgba(0,0,0,.5);

		> ul {
			height: 100%;
			overflow-y: scroll;
			margin: 0;
			padding: 0;
			list-style: none;
			border-radius: 4px;

			li {
				padding: 0 1em;

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

		.pokemon-detail {
			width: 50vh;
			padding: 2em;

			img {
				width: 100%;
				height: auto;
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
