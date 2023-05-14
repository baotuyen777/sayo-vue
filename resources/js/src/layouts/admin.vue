<template>
    day la layout admin
    <TheHeader/>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-3">
                <a-list bordered style="width:100%">

                    <template #header>
                        <div>Bảng điều khiển</div>
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
import TheHeader from "../components/TheHeader.vue";
import TheMenu from "../components/TheMenu.vue";

export default {
    components: {
        TheHeader,
        TheMenu
    }
}
</script>
