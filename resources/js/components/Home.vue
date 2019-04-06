<template>
	<div class="home">
		<img :src="require('../../img/pokemon-logo.png')" alt="Pokemon">
		<h1>Victory Road</h1>
	</div>
</template>


<script>
    export default {
        mounted() {
        }
    }
</script>

<style lang="scss">
.home {
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	background: tomato;
	color: #FFF;

	img {
		max-width: 75vw;
	}

	h1 {
		font-size: 4em;
	}
}
</style>
