<script setup>
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'

const props = defineProps({
  togglerIcon: {
    type: String,
    required: false,
    default: 'tabler-layout-grid-add',
  },
  shortcuts: {
    type: Array,
    required: true,
  },
})

const router = useRouter()
</script>

<template>
  <VBtn
    variant="text"
    color="default"
    size="small"
    icon
  >
    <VIcon
      size="24"
      :icon="props.togglerIcon"
    />

    <VMenu
      activator="parent"
      offset="14px"
      location="bottom end"
    >
      <VCard
        width="340"
        max-height="560"
        class="d-flex flex-column"
      >
        <VCardItem class="py-4">
          <VCardTitle>Shortcuts</VCardTitle>

          <template #append>
            <VBtn
              size="x-small"
              variant="text"
              color="default"
              icon
            >
              <VIcon
                size="22"
                icon="tabler-layout-grid-add"
              />
            </VBtn>
          </template>
        </VCardItem>

        <VDivider />

        <PerfectScrollbar :options="{ wheelPropagation: false }">
          <VRow class="ma-0 mt-n1">
            <VCol
              v-for="(shortcut, index) in props.shortcuts"
              :key="shortcut.title"
              cols="6"
              class="text-center border-t cursor-pointer pa-4"
              :class="(index + 1) % 2 ? 'border-e' : ''"
              @click="router.push(shortcut.to)"
            >
              <VAvatar
                variant="tonal"
                size="48"
              >
                <VIcon :icon="shortcut.icon" />
              </VAvatar>

              <h6 class="text-base font-weight-semibold mt-2 mb-0">
                {{ shortcut.title }}
              </h6>
              <span class="text-sm">{{ shortcut.subtitle }}</span>
            </VCol>
          </VRow>
        </PerfectScrollbar>
      </VCard>
    </VMenu>
  </VBtn>
</template>
