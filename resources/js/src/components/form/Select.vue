<template>
    <div class="mb-3 d-flex align-items-center gap-2">
        <label>
            <span class="text-danger me-1">*</span>
            <span :class="{'text-danger': error_mes}">{{ label }}</span>
        </label>

        <div>
            <!--            <a-input-->
            <!--                :placeholder="placeholder || label"-->
            <!--                :value="modelValue"-->
            <!--                @input="$emit('update:modelValue', $event.target.value)"-->
            <!--                :class="{'input-danger':error_mes}"-->
            <!--            />-->

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

const props = defineProps(['modelValue', 'placeholder', 'error_mes', 'label', 'options']);

defineEmits(['update:modelValue']);

// const emit = defineEmits({
//     change: (value) => {
//         return value
//     }
// })
//
// const handleChange = value => {
//     console.log(value); // { key: "lucy", label: "Lucy (101)" }
//     emit('change', {modelValue: value});
// };

const filterOption = (input, option) => {
    return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
}
const a = 1111;
</script>
