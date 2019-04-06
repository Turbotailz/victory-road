<template>
	<nav>
		<router-link to="/" class="logo">
			<img :src="require('../../img/pokemon-logo.png')" alt="Pokemon">
			Victory Road
		</router-link>

		<ul>
			<li>
				<router-link to="/quiz">Quiz</router-link>
			</li>
			<li>
				<router-link to="/pokedex">Pokedex</router-link>
			</li>
		</ul>
	</nav>
</template>

<script>
    export default {
        mounted() {
        }
    }
</script>

<style lang="scss">
nav {
	height: 4em;
	background: tomato;
	display: flex;
	justify-content: space-between;

	.logo {
		display: flex;
		height: 100%;
		align-items: center;

		img {
			height: 100%;
			width: auto;
			margin-right: 1em;
		}
	}

	a {
		color: #FFF;
		padding: .5em 1em;
		height: 100%;
		display: flex;
		align-items: center;

		&:hover {
			color: #FFF;
			text-decoration: underline;
		}
	}

	ul {
		list-style: none;
		margin: 0;
		padding: 0;
		display: flex;
	}
}
</style>
