<script setup>
import BarChart from '@/@core/libs/chartjs/components/BarChart'
import { getLatestBarChartConfigDaily } from '@core/libs/chartjs/chartjsConfig'
import { useTheme } from 'vuetify'
import useGlobalStore from '../../../stores/globalStore'
import { ref, reactive, computed } from "vue"

const props = defineProps({
  colors: {
    type: Object,
    required: true,
  },
})

const globalStore = useGlobalStore()
const vuetifyTheme = useTheme()
const chartOptions = computed(() => {
  const result = getLatestBarChartConfigDaily(vuetifyTheme.current.value)
  return { result, key: Date.now() }
})

const data = reactive({
  labels: [
  ],
  datasets: [{
    maxBarThickness: 15,
    backgroundColor: props.colors.barChartYellow,
    borderColor: 'transparent',
    borderRadius: {
      topRight: 15,
      topLeft: 15,
    },
    data: [
    ],
  }],
})

watch(() => globalStore.totalQueryDaily, newTotalQuery => {
  data.labels = Array.from(Object.keys(newTotalQuery))
  data.datasets[0].data = Array.from(Object.values(newTotalQuery))
})
</script>

<template>
  <BarChart key="keytest2" :height="400" :chart-data="data" :chart-options="chartOptions.result"
    :key="chartOptions.key" />
</template>
