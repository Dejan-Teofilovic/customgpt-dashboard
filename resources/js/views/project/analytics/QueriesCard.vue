<template>
  <h2 :style="{ fontSize: '22px' }">
    Chat Metrics
  </h2>
  <VCard>
    <div :style="{ padding: '24px 24px 0px 24px', fontSize: '22px' }">
      Queries
    </div>
    <VCardText class="pt-6">
      <VRow>
        <VCol v-for="item in statistics" :key="item.title" cols="6" class="custom-col" md="3">
          <div class="queries-card gap-blocks"
            :style="{ border: '1px solid #9e9e9e', borderRadius: '10px', padding: '16px', height: '100%' }">
            <VAvatar :color="item.color" variant="tonal" size="42" class="me-3">
              <VIcon size="24" :icon="item.icon" />
            </VAvatar>

            <div class="d-flex flex-column">
              <span class="text-h5 font-weight-medium gap-statistics" :style="{ marginTop: '16px' }">{{ item.stats
              }}</span>
              <span class="text-caption sub-information" :style="{ fontSize: '15px !important' }">
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
import { ref } from 'vue'
import useGlobalStore from '../../../stores/globalStore'

const globalStore = useGlobalStore()

const name = ref('Apples')
const message = ref('I like apples')

const statistics = ref([
  {
    title: 'Queries',
    stats: globalStore.totalQueryCount,
    icon: 'custom-message-circle-2',
    color: 'primary',
  },
  {
    title: 'Response End Time',
    stats: parseFloat(globalStore.avgResponseEndTime).toFixed(1) + "s",
    icon: 'custom-prompt',
    color: 'info',
  },
  {
    title: 'Response Start Time',
    stats: parseFloat(globalStore.avgResponseStartTime).toFixed(1) + "s",
    icon: 'custom-clock',
    color: 'warn',
  },
  {
    title: 'Inputs Words',
    stats: parseFloat(globalStore.avgQueryInputWord).toFixed(0),
    icon: 'custom-users',
    color: 'error',
  },
  {
    title: 'Output Words',
    stats: parseFloat(globalStore.avgQueryOutputWord).toFixed(0),
    icon: 'custom-users',
    color: 'error',
  },
])

watch(() => globalStore.totalQueryCount, newTotalQuery => {
  const updatedStatistics = statistics.value.map(stat => {
    if (stat.title === 'Queries') {
      stat.stats = newTotalQuery
    }

    return stat
  })

  statistics.value = updatedStatistics
})
watch(() => globalStore.avgResponseEndTime, newTotalQuery => {

  const updatedStatistics = statistics.value.map(stat => {
    if (stat.title === 'Response End Time') {
      const originalNumber = parseFloat(newTotalQuery)
      const formattedString = originalNumber.toFixed(1) + "s"

      stat.stats = newTotalQuery == null ? 0 : formattedString
    }

    return stat
  })

  statistics.value = updatedStatistics
})
watch(() => globalStore.avgResponseStartTime, newTotalQuery => {

  const updatedStatistics = statistics.value.map(stat => {
    if (stat.title === 'Response Start Time') {
      const originalNumber = parseFloat(newTotalQuery)
      const formattedString = originalNumber.toFixed(1) + "s"

      stat.stats = newTotalQuery == null ? 0 : formattedString
    }

    return stat
  })

  statistics.value = updatedStatistics
})
watch(() => globalStore.avgQueryInputWord, newTotalQuery => {

  const updatedStatistics = statistics.value.map(stat => {
    if (stat.title === 'Inputs Words') {
      stat.stats = Math.floor(newTotalQuery)
    }

    return stat
  })

  statistics.value = updatedStatistics
})

watch(() => globalStore.avgQueryOutputWord, newTotalQuery => {

  const updatedStatistics = statistics.value.map(stat => {
    if (stat.title === 'Output Words') {

      stat.stats = Math.floor(newTotalQuery)
    }

    return stat
  })

  statistics.value = updatedStatistics
})
</script>

<style scoped>
.custom-col {
  flex: 0 0 20% !important;
  padding: 12px !important;
  inline-size: 100% !important;
  max-inline-size: 50% !important;
}
</style>
