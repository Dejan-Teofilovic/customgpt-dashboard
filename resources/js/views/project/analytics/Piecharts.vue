<script setup>

import { getDonutChartConfig } from '@core/libs/apex-chart/apexCharConfig'
import VueApexCharts from 'vue3-apexcharts'
import { useTheme } from 'vuetify'
import useGlobalStore from '../../../stores/globalStore'
import { ref, reactive, computed, onRenderTracked, onRenderTriggered, nextTick } from 'vue'

const props = defineProps(['labels', 'series', 'key', 'title'])
const vuetifyTheme = useTheme()

const expenseRationChartConfig = computed(() => {
  let result = getDonutChartConfig(vuetifyTheme.current.value, props.labels, props.title)
  return { result, key: new Date() };
})

const computedseries = computed(() => {
  console.log("---------------------" + props.series + "------------------------")
  return Array.from(props.series)
})

</script>

<template>
  <VueApexCharts :key="expenseRationChartConfig.key" type="donut" height="410" :options="expenseRationChartConfig.result"
    :series="props.series" />
</template>

