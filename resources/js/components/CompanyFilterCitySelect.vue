<template>
    <fake-select
        placeholder="Todas"
        label="Cidade"
        :options="data"
        name="city"
        @handleInput="handleInput"
        @open="handleOpen"
        @loadMore="handleLoadMore"
        ref="fakeSelect"
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
            this.$refs.fakeSelect.clear()
            this.getData()
        })
    },
    methods: {
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
            axios.get('/api/cities', {
                params: {
                    q: this.q,
                    uf: this.state ? this.state.uf : null,
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
