<script setup>
// Import necessary components and libraries.
import BarChart from '@/@core/libs/chartjs/components/BarChart'
import { getLatestBarChartConfig } from '@core/libs/chartjs/chartjsConfig'
import { useTheme } from 'vuetify'
import useGlobalStore from '../../../stores/globalStore'
import { reactive, computed, ref } from "vue"

// Define component props.
const props = defineProps({
  colors: {
    type: Object,
    required: true,
  },
})

// Get a reference to the global store.
const globalStore = useGlobalStore()

// Access the Vuetify theme and compute the chart options.
const vuetifyTheme = useTheme()
const chartOptions = computed(() => {
  const result = getLatestBarChartConfig(vuetifyTheme.current.value)
  return { result, key: Date.now() }
})


// Create a reactive data object for the chart.
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

// Watch for changes in the global store's totalQueryHourly property and update the chart data accordingly.
watch(() => globalStore.totalQueryHourly, newTotalQuery => {
  data.labels = Array.from(Object.keys(newTotalQuery))
  data.datasets[0].data = Array.from(Object.values(newTotalQuery))
})
</script>

<template>
  <!-- Render the BarChart component with specified properties. -->
  <BarChart key="testkey1" :height="400" :chart-data="data" :chart-options="chartOptions.result"
    :key="chartOptions.key" />
</template>
