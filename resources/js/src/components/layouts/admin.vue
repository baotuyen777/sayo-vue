<template>
    <TheHeader/>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-3">
                <a-list bordered style="width:100%">
                    <template #header>
                        Bảng điều khiển
                    </template>
                    <TheMenu/>
                </a-list>
            </div>

            <div class="col-12 col-md-9">
                <router-view></router-view>
            </div>
        </div>
    </div>

</template>
<script>
import TheHeader from "./TheHeader.vue";
import TheMenu from "./TheMenu.vue";

export default {
    components: {
        TheHeader,
        TheMenu
    }
}
</script>
