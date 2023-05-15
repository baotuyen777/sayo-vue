<template>
    setting
</template>
<script>
import {useMenu} from "@/src/store/use-menu.js";

export default {
    setup() {
        useMenu().onSelectedKeys(['admin-settings']);
    }
}
</script>
