<template>
    <div class="company-list-container">
        <company-list-skeleton-loading v-if="loading"></company-list-skeleton-loading>
        <p class="no-records" v-if="companies && companies.data.length === 0">Parece que não foi encontrado nenhuma empresa :( tente mudar os filtros</p>
        <div class="company-list-wrapper" v-if="companies && companies.data?.length">
            <div class="company-list-item" v-for="company in companies.data">
                <h2>{{ company.name }}</h2>
                <p>{{ truncate(company.description) }}</p>
                <div class="company-list-actions">
                    <a :href="`mailto: ${company.email}`" title="Enviar email">Enviar email</a>
                    <a :href="`https://wa.me/${onlyNumbers(company.phone)}`" target="_blank">Whatsapp</a>
                </div>
            </div>
        </div>
        <button v-if="companies && companies.next_page_url" class="company-list-load-more" @click="loadMore">
            {{ loadingMore ? "Carregando..." : "Carregar mais"}}
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            companies: undefined,
            name: null,
            stateUf: null,
            cityId: null,
            loadingMore: false,
            loading: false
        }
    },
    watch: {
        name() {
            this.getData()
        },
        stateUf() {
            this.getData()
        },
        cityId() {
            this.getData()
        },
    },
    mounted() {
        this.getData()

        this.emitter.on('update-name-filter', val => {
            this.name = val
        })

        this.emitter.on('state-selected', val => {
            this.stateUf = val?.uf
        })

        this.emitter.on('city-selected', val => {
            this.cityId = val?.id
        })
    },
    methods: {
        loadMore() {
            this.getData(this.companies.current_page + 1)
        },
        onlyNumbers(str) {
            return str.replaceAll(/\D/g, '')
        },
        truncate(str) {
            const clamp = '...'
            return str.length > 75 ? str.slice(0, 75) + clamp : str
        },
        getData(page = 1) {
            if (page === 1) {
                this.loading = true
            }

            axios.get('/api/companies', {
                params: {
                    page: page,
                    name: this.name,
                    uf: this.stateUf,
                    city: this.cityId
                }
            }).then(({data}) => {
                if (page > 1) {
                    let oldData = this.companies.data
                    data.data = oldData.concat(data.data)
                }
                this.companies = data

                this.loading = false
            });
        }
    }
}
</script>
