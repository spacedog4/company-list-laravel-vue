<template>
    <div class="company-filter-wrap">
        <div class="company-filter-input-style">
            <label for="name">Buscar</label>
            <input id="name" autocomplete="nope" placeholder="Digite o nome" @focus="handleInputFocus" @focusout="handleInputFocusOut">
            <span class="icon">
                <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.0295 15.8333C14.0579 15.8333 17.3236 12.8486 17.3236 9.16667C17.3236 5.48477 14.0579 2.5 10.0295 2.5C6.00104 2.5 2.73535 5.48477 2.73535 9.16667C2.73535 12.8486 6.00104 15.8333 10.0295 15.8333Z"
                        stroke="#2E6773" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M19.1471 17.5L15.1809 13.875" stroke="#2E6773" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </span>
        </div>

        <company-filter-state-select></company-filter-state-select>
        <company-filter-city-select></company-filter-city-select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedState: '',
            selectedStateLabel: 'Todas'
        }
    },
    mounted() {
    },
    methods: {
        handleInputFocus(e) {
            e.target.closest('.company-filter-input-style').classList.add('focus');
        },
        handleInputFocusOut(e) {
            e.target.closest('.company-filter-input-style').classList.remove('focus');
        },
    }
}
</script>

<style lang="scss">
.company-filter-wrap {
    display: flex;
    gap: 1rem;

    .company-filter-input-style {
        width: 30%;

        &:first-child {
            width: 40%;
        }
    }
}
</style>

