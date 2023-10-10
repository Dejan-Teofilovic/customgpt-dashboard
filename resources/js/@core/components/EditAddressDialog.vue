<script setup>
const props = defineProps({
  billingAddress: {
    type: Object,
    required: true,
  },
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const billingAddress = ref(structuredClone(toRaw(props.billingAddress)))

const resetForm = () => {
  emit('update:isDialogVisible', false)
  billingAddress.value = structuredClone(toRaw(props.billingAddress))
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', billingAddress.value)
}

const dialogModelValueUpdate = val => {
  emit('update:isDialogVisible', val)
}
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 650 "
    :model-value="props.isDialogVisible"
    @update:model-value="dialogModelValueUpdate"
  >
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="dialogModelValueUpdate(false)" />

    <VCard
      v-if="props.billingAddress"
      class="pa-sm-9 pa-5"
    >
      <!-- 👉 Title -->
      <VCardItem>
        <VCardTitle class="text-h5 text-center mb-3">
          Edit Address
        </VCardTitle>
        <!-- 👉 Subtitle -->
        <p class="text-center">
          Edit Address for future billing
        </p>
      </VCardItem>

      <VCardText>
        <!-- 👉 Form -->
        <VForm @submit.prevent="onFormSubmit">
          <VRow>
            <!-- 👉 Company Name -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="billingAddress.companyName"
                label="Company Name"
              />
            </VCol>

            <!-- 👉 Email -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="billingAddress.billingEmail"
                label="Email"
              />
            </VCol>

            <!-- 👉 Tax ID -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="billingAddress.taxID"
                label="Tax ID"
              />
            </VCol>

            <!-- 👉 VAT Number -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="billingAddress.vatNumber"
                label="VAT Number"
              />
            </VCol>

            <!-- 👉 Billing Address -->
            <VCol cols="12">
              <VTextarea
                v-model="billingAddress.address"
                rows="2"
                label="Billing Address"
              />
            </VCol>

            <!-- 👉 Contact -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="billingAddress.contact"
                label="Contact"
              />
            </VCol>

            <!-- 👉 Country -->
            <VCol
              cols="12"
              md="6"
            >
              <VSelect
                v-model="billingAddress.country"
                label="Country"
                :items="['USA', 'Uk', 'France', 'Germany', 'Japan']"
              />
            </VCol>

            <!-- 👉 State -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="billingAddress.state"
                label="State"
              />
            </VCol>

            <!-- 👉 Zip Code -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="billingAddress.zipCode"
                label="Zip Code"
              />
            </VCol>

            <!-- 👉 Submit and Cancel button -->
            <VCol
              cols="12"
              class="text-center"
            >
              <VBtn
                type="submit"
                class="me-3"
              >
                submit
              </VBtn>

              <VBtn
                variant="tonal"
                color="secondary"
                @click="resetForm"
              >
                Cancel
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>
