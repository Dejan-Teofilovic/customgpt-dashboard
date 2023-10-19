<template>
  <VCard :style="{ marginTop: '16px' }">
    <div :style="{ padding: '24px 24px 0px 24px', fontSize: '22px' }" />
    <VCardText class="pt-6">
      <VRow>
        <VCol
          v-for="item in statistics"
          :key="item.title"
          cols="4"
          md="4"
        >
          <div
            class="queries-card gap-blocks"
            :style="{ border: '1px solid #9e9e9e', borderRadius: '10px', padding: '16px', height: '100%' }"
          >
            <VAvatar
              :color="item.color"
              variant="tonal"
              size="42"
              class="me-3"
            >
              <VIcon
                size="24"
                :icon="item.icon"
              />
            </VAvatar>

            <div class="d-flex flex-column">
              <span
                class="text-h5 font-weight-medium gap-statistics"
                :style="{ marginTop: '16px' }"
              >{{ item.stats
              }}</span>
              <span
                class="text-caption sub-information"
                :style="{ fontSize: '15px !important' }"
              >
                {{ item.title }}
              </span>
            </div>
          </div>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>


<script setup>
// imoprt the necessary modules
import { ref, reactive } from 'vue'
import useGlobalStore from '../../../stores/globalStore'

const globalStore = useGlobalStore()

const statistics = ref([
  {
    title: 'Conversations',
    stats: '0',
    icon: 'custom-message-circle-2',
    color: 'primary',
  },
  {
    title: 'Queries per conversation',
    stats: '0',
    icon: 'custom-users',
    color: 'error',
  },
  {
    title: 'Conversation Time',
    stats: '0',
    icon: 'custom-prompt',
    color: 'info',
  },
])

watch(() => globalStore.totalConversationCount, newTotalQuery => {
  const updatedStatistics = statistics.value.map(stat => {

    if (stat.title === 'Conversations') {
      stat.stats = newTotalQuery.result
    }
    
    return stat
  })

  statistics.value = updatedStatistics
})

watch(() => globalStore.avgQueryPerConversation, newTotalQuery => {
  const updatedStatistics = statistics.value.map(stat => {

    if (stat.title === 'Queries per conversation') {
      stat.stats = newTotalQuery.result.toFixed(1)
    }
    
    return stat
  })

  statistics.value = updatedStatistics
})

watch(() => globalStore.avgTimePerConversation, newTotalQuery => {
  const updatedStatistics = statistics.value.map(stat => {
    if (stat.title === 'Conversation Time') {
      stat.stats = newTotalQuery.result.toFixed(1)
    }
    
    return stat
  })

  statistics.value = updatedStatistics
})
</script>

<style scoped></style>
