<template>
    <div class="companies-container">
        <div class="box">
            <company-filter></company-filter>
            <company-list></company-list>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style lang="scss">
    .companies-container {
        max-width: 768px;
        width: 100%;
        margin: 0 auto;
        padding: 2.5rem;
    }
</style>
