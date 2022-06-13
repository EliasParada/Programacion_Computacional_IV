<template>
    <div>
    </div>
</template>

<script>
export default {
    props: ['message', 'timeout', 'type', 'theme'],
    data() {
        return {
        }
    },
    mounted() {
        this.$root.$emit('newToast', {
            message: this.message,
            timeout: this.timeout,
            type: this.type,
            theme: this.theme,
        });
    },
}
</script>