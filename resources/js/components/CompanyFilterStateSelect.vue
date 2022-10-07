<template>
    <fake-select
        placeholder="Todos"
        label="Estado"
        :options="data"
        name="state"
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
    },
    methods: {
        handleSelected(item) {
            this.emitter.emit('state-selected', item);
        },
        handleInput(e) {
            this.q = e.target.value
        },
        handleOpen(val) {
            console.log(val)
            if (!val) {
                this.q = null
            }
        },
        getData() {
            this.data = undefined;

            axios.get('/api/states', {
                params: {
                    q: this.q
                }
            }).then(({data}) => {
                this.data = data;
            });
        }
    }
}
</script>
