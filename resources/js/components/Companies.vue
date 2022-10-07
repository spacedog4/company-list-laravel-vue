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
