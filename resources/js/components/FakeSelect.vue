<template>
    <div class="company-filter-input-style fake-select" :class="{opened: open}">
        <label>{{ label }}</label>
        <input autocomplete="nope" :title="label" class="fake-select-value" ref="fakeSelectInput"
               @focus="handleInputFocus"
               v-model="selectedOptionInput" @input="e => this.$emit('handleInput', e)">
        <span class="icon" @click="toggleSelect">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M4.46967 6.96967C4.76256 6.67678 5.23744 6.67678 5.53033 6.96967L10 11.4393L14.4697 6.96967C14.7626 6.67678 15.2374 6.67678 15.5303 6.96967C15.8232 7.26256 15.8232 7.73744 15.5303 8.03033L10.5303 13.0303C10.2374 13.3232 9.76256 13.3232 9.46967 13.0303L4.46967 8.03033C4.17678 7.73744 4.17678 7.26256 4.46967 6.96967Z"
                      fill="#608289"/>
            </svg>
        </span>
        <div class="fake-select-dropdown">
            <div class="fake-select-item" @click="selectOption(null)">{{ placeholder }}</div>
            <div class="fake-select-item" v-for="item in options?.data" @click="selectOption(item)">{{
                    item.name
                }}
            </div>
            <p ref="fakeSelectBottomLoader" class="fake-select-bottom-loader" v-show="options && options.next_page_url">Carregando...</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        placeholder: {
            type: String,
            default: 'Selecione'
        },
        label: {
            type: String,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        options: {
            type: Object
        }
    },
    data() {
        return {
            selectedOption: '',
            selectedOptionInput: this.placeholder,
            open: false,
            data: undefined
        }
    },
    watch: {
        open(val) {
            this.$emit('open', val)
        },
        selectedOption(val) {
            this.$emit('selected', val)
        }
    },
    mounted() {
        setTimeout(() => {
            this.startObserver()
        }, 100)

        window.addEventListener('click', e => {
            if (e.target.closest('.company-filter-input-style') !== this.$el && this.open) {
                this.closeSelect()
            }
        });
    },
    methods: {
        clear() {
            this.selectedOption = ''
            this.selectedOptionInput = this.placeholder
        },
        startObserver() {
            let observer = new IntersectionObserver((entries, opts) => {
                if (entries[0].isIntersecting && this.options && (this.options.data && this.options.next_page_url)) {
                    this.$emit('loadMore');
                }
            }, {
                root: null,
                threshold: 0
            });
            observer.observe(this.$refs.fakeSelectBottomLoader)
        },
        handleInputFocus() {
            this.openSelect();

            if (!this.selectedOption) {
                this.selectedOptionInput = ''
            }
        },
        openSelect() {
            this.open = true
        },
        closeSelect() {
            this.open = false

            if (this.selectedOption) {
                this.selectedOptionInput = this.selectedOption.name;
            } else {
                this.selectedOptionInput = "Todos";
            }
        },
        toggleSelect() {
            this.open = !this.open
        },
        selectOption(item) {
            this.selectedOption = item;

            this.selectedOptionInput = item ? item.name : 'Todos'

            this.closeSelect();
        }
    }
}
</script>
