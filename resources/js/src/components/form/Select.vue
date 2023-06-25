<template>
    <div class="form-item">
        <label>
            <span class="text-danger me-1">*</span>
            <span :class="{'text-danger': error_mes}">{{ label }}</span>
        </label>

        <div class="form-control">
            <a-select
                show-search
                placeholder="Tình trạng"
                :options="options"
                :filter-option="filterOption"
                :value="modelValue"
                @change="(value)=>$emit('update:modelValue', value)"
                :class="{'select-danger': error_mes}"
            />
            <small v-if="error_mes" class="text-danger">{{ error_mes[0] }}</small>
        </div>
    </div>
</template>

<script setup>


const props = defineProps({
    options: {
        default: [
            {value: 1, label: "Hoạt động"},
            {value: 2, label: "Tạm dừng"},
        ]
    },
    modelValue: {},
    placeholder: {},
    error_mes: {},
    label: {},

});

defineEmits(['update:modelValue']);

const filterOption = (input, option) => {
    return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
}
</script>
