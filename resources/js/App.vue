<template>
    <div class="app-wrap">
        <navigation />
        <router-view :pokemon="pokemon" />
    </div>
</template>

<script>
import Navigation from './components/Navigation';

export default {
    components: {
        Navigation,
    },

    data: () => {
        return {
            pokemon: null,
        }
    },

    mounted() {
        axios.get('/api/pokemon')
        .then(res => {
            this.pokemon = res.data;
        })
        .catch(error => { console.error });
    }
}
</script>

<style lang="scss">
.app-wrap {
    height: 100%;
    display: flex;
    flex-direction: column;

    > div {
        flex: 1 0 auto;
    }
}
</style>
