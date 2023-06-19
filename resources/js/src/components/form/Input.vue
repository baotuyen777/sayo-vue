<template>
    <div class="form-item">
        <label>
            <span class="text-danger me-1">*</span>
            <span :class="{'text-danger': error_mes}">{{ label }}</span>
        </label>

        <div class="form-control">
            <a-input
                :placeholder="placeholder || label"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                :class="{'input-danger':error_mes}"
                allow-clear
            />

            <small v-if="error_mes" class="text-danger">{{ error_mes[0] }}</small>
        </div>
    </div>
</template>

<script setup>

const props = defineProps(['modelValue', 'placeholder', 'error_mes', 'label']);

defineEmits(['update:modelValue'])

</script>
