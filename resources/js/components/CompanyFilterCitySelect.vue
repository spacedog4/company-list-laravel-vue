<template>
    <fake-select
        placeholder="Todas"
        label="Cidade"
        :options="data"
        name="city"
        @handleInput="handleInput"
        @open="handleOpen"
        @selected="handleSelected"
    ></fake-select>
</template>

<script>
export default {
    data() {
        return {
            q: null,
            state: null,
            data: undefined
        }
    },
    watch: {
        q() {
            this.getData()
        }
    },
    mounted() {
        this.getData()

        this.emitter.on('state-selected', item => {
            this.state = item
            this.getData()
        })
    },
    methods: {
        handleSelected(item) {
            this.emitter.emit('state-selected', item);
        },
        handleInput(e) {
            this.q = e.target.value
        },
        handleOpen(val) {
            if (!val) {
                this.q = null
            }
        },
        getData() {
            this.data = undefined;

            axios.get('/api/cities', {
                params: {
                    q: this.q,
                    uf: this.state ? this.state.uf : null
                }
            }).then(({data}) => {
                this.data = data;
            });
        }
    }
}
</script>
