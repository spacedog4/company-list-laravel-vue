<template>
    <fake-select
        placeholder="Todos"
        label="Estado"
        :options="data"
        name="state"
        @handleInput="handleInput"
        @open="handleOpen"
        @selected="handleSelected"
        @loadMore="handleLoadMore"
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
            if (!val) {
                this.q = null
            }
        },
        handleLoadMore() {
            this.getData(this.data.current_page + 1);
        },
        getData(page = 1) {
            axios.get('/api/states', {
                params: {
                    q: this.q,
                    page: page
                }
            }).then(({data}) => {
                if (page > 1) {
                    let oldData = this.data.data
                    data.data = oldData.concat(data.data)
                }
                this.data = data
            });
        }
    }
}
</script>
