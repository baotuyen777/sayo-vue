<template>
    <div :class="classWrapper || 'mb-3 mt-3 col-md-6'">
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
                    type="type|| 'text'"
                    :status="status"
                    v-if="type!=='password'"
                >
                    <template #prefix v-if="icon">
                        <i :class="'fa-solid fa-'+icon"></i>
                    </template>
                </a-input>
                <a-input-password v-model="password" v-if="type==='password'">
                    <template #prefix>
                        <i class="fa-solid fa-lock"></i>
                    </template>
                </a-input-password>

                <small v-if="error_mes" class="text-danger">{{ error_mes[0] }}</small>
            </div>
        </div>
    </div>

</template>

<script setup>

const props = defineProps(['modelValue', 'placeholder', 'error_mes', 'label', 'type', 'classWrapper', 'icon', 'status']);

defineEmits(['update:modelValue'])

</script>
