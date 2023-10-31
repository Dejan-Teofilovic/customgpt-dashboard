<script setup>
import { hexToRgb } from '@layouts/utils'
import VueApexCharts from 'vue3-apexcharts'
import { useTheme } from 'vuetify'
import useGlobalStore from '../../../stores/globalStore'
import { ref } from 'vue'

const globalStore = useGlobalStore()
const vuetifyTheme = useTheme()

// Define the states
const currentTab = ref(0)
const currentTabForBarchart = ref(0)
const refVueApexChart = ref()
const chartLabel = ref([[], [], [], [], [], [], [], []])
const chartData = ref([[], [], [], [], [], [], [], []])
const highlightedIndex = ref(0)

const selectTab = index => {
  if (currentTab.value == index)
    return

  globalStore.setcurrentSelectedDailyBreakdown(index)

  const urls = [{ endpoint: 'daily-breakdown-query', property: 'dailyBreakdownQuery' },
  { endpoint: 'daily-breakdown-response-start-time', property: 'dailyBreakdownResponseStartTime' },
  { endpoint: 'daily-breakdown-response-end-time', property: 'dailyBreakdownResponseEndTime' },
  { endpoint: 'daily-breakdown-input-word', property: 'dailyBreakdownInputWord' },
  { endpoint: 'daily-breakdown-output-word', property: 'dailyBreakdownOutputWord' },
  { endpoint: 'daily-breakdown-conversations', property: 'dailyBreakdownConversations' },
  { endpoint: 'daily-breakdown-query-per-conversation', property: 'dailyBreakdownQueryPerConversation' },
  { endpoint: 'daily-breakdown-conversation-time', property: 'dailyBreakdownConversationTime' }]

  currentTab.value = index
  globalStore.fetchDataFromApi(urls[index].endpoint, urls[index].property)
}


function formatFloatVariable(variable) {
  // Check if the variable is a number or a string that represents a float
  if (typeof variable === 'number' || (typeof variable === 'string' && !isNaN(parseFloat(variable)))) {
    const floatValue = parseFloat(variable)
    if (!Number.isInteger(floatValue)) {
      return floatValue.toFixed(1) // Format with 1 decimal place
    }
  }

  // If the variable is not a float, return it as is
  return variable
}

const buttonData = ref([
  { title: 'Queries', icon: 'tabler-question-mark' },
  { title: 'Response Start Time', icon: 'tabler-clock' },
  { title: 'Response End Time', icon: 'tabler-clock' },
  { title: 'Input Words', icon: 'tabler-letter-a' },
  { title: 'Output Words', icon: 'tabler-letter-a' },
  { title: 'Conversations', icon: 'tabler-message' },
  { title: 'Queries Per Conversation', icon: 'tabler-question-mark' },
  { title: 'Conversation Time', icon: 'tabler-chart-pie-2' },
])

const chartConfigs = computed(() => {
  const currentTheme = vuetifyTheme.current.value.colors
  const variableTheme = vuetifyTheme.current.value.variables
  const labelPrimaryColor = `rgba(${hexToRgb(currentTheme.primary)},${variableTheme['dragged-opacity']})`
  const legendColor = `rgba(${hexToRgb(currentTheme['on-background'])},${variableTheme['high-emphasis-opacity']})`
  const borderColor = `rgba(${hexToRgb(String(variableTheme['border-color']))},${variableTheme['border-opacity']})`
  const labelColor = `rgba(${hexToRgb(currentTheme['on-surface'])},${variableTheme['disabled-opacity']})`

  return {
    title: buttonData.value[currentTabForBarchart.value].title,
    key: new Date().toString(),
    icon: buttonData.value[currentTabForBarchart.value].icon,
    chartOptions: {
      chart: {
        parentHeightOffset: 0,
        type: 'bar',
        toolbar: { show: false },
      },
      plotOptions: {
        bar: {
          columnWidth: '32%',
          startingShape: 'rounded',
          borderRadius: 4,
          distributed: true,
          dataLabels: { position: 'top' },
        },
      },
      grid: {
        show: false,
        padding: {
          top: 0,
          bottom: 0,
          left: -10,
          right: -10,
        },
      },
      colors: chartLabel.value[currentTabForBarchart.value].map((value, index, arr) => {
        if (index == highlightedIndex.value) {
          return currentTheme.primary
        }
        return labelPrimaryColor
      }),
      dataLabels: {
        enabled: true,
        formatter(val) {
          return `${val}`
        },
        offsetY: -25,
        style: {
          fontSize: '15px',
          colors: [legendColor],
          fontWeight: '600',
          fontFamily: 'Public Sans',
        },
      },
      legend: { show: false },
      tooltip: { enabled: false },
      xaxis: {
        categories: [
          ...chartLabel.value[currentTabForBarchart.value],
        ],
        axisBorder: {
          show: true,
          color: borderColor,
        },
        axisTicks: { show: false },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '14px',
            fontFamily: 'Public Sans',
          },
        },
      },
      yaxis: {
        labels: {
          offsetX: -15,
          formatter(val) {
            return `${parseInt(val)}`
          },
          style: {
            fontSize: '14px',
            colors: labelColor,
            fontFamily: 'Public Sans',
          },
          min: 0,
          max: 60000,
          tickAmount: 6,
        },
      },
      responsive: [
        {
          breakpoint: 1441,
          options: { plotOptions: { bar: { columnWidth: '41%' } } },
        },
        {
          breakpoint: 590,
          options: {
            plotOptions: { bar: { columnWidth: '61%' } },
            yaxis: { labels: { show: false } },
            grid: {
              padding: {
                right: 0,
                left: -20,
              },
            },
            dataLabels: {
              style: {
                fontSize: '12px',
                fontWeight: '400',
              },
            },
          },
        },
      ],
    },
    series: [{
      data: [
        ...chartData.value[currentTabForBarchart.value],
      ],
    }],
  }

})

const variablesToWatch = [
  'globalStore.dailyBreakdownResponseStartTime',
  "globalStore.dailyBreakdownQuery",
  "globalStore.dailyBreakdownResponseStartTime",
  "globalStore.dailyBreakdownResponseEndTime",
  "globalStore.dailyBreakdownInputWord",
  "globalStore.dailyBreakdownOutputWord",
  "globalStore.dailyBreakdownConversations",
  "globalStore.dailyBreakdownQueryPerConversation",
  "globalStore.dailyBreakdownConversationTime",
]

// Create a watch statement for each variable
variablesToWatch.forEach(variableName => {
  watch(() => eval(variableName), newTotalQuery => {
    currentTabForBarchart.value = currentTab.value
    console.log("-------------------------------------");
    console.log(newTotalQuery)
    let stat = chartConfigs.value
    const convertedObject = {}
    let biggest = 0
    let beggestIndex = 0
    let indexTest = 0
    for (const key in newTotalQuery) {
      if (newTotalQuery.hasOwnProperty(key)) {
        // Split the date string into its components
        const dateComponents = key.split('-')

        // Extract the month and day
        const month = parseInt(dateComponents[1], 10)
        const day = parseInt(dateComponents[2], 10)
        const convertedKey = `${month}/${day}`

        convertedObject[convertedKey] = formatFloatVariable(newTotalQuery[key])
        if (newTotalQuery[key] > biggest) {
          biggest = newTotalQuery[key]
          beggestIndex = indexTest
        }
      }
      indexTest++
    }

    stat.series[0].data.length = 0
    stat.chartOptions.xaxis.categories.length = 0
    stat.chartOptions.colors[beggestIndex] = vuetifyTheme.current.value.colors.primary
    chartLabel.value[currentTabForBarchart.value].length = 0
    chartData.value[currentTabForBarchart.value].length = 0
    chartLabel.value[currentTabForBarchart.value] = Array.from(Object.keys(convertedObject))
    chartData.value[currentTabForBarchart.value] = Array.from(Object.values(convertedObject))
    highlightedIndex.value = beggestIndex
  })
})
</script>

<template>
  <VCard title="Daily Breakdown" subtitle="Last 7 days">
    <template #append>
      <div class="mt-n4 me-n2">
        <VBtn icon size="x-small" variant="plain" color="default" />
      </div>
    </template>

    <VCardText>
      <div :style="{ display: 'flex', flexWrap: 'wrap' }">
        <div v-for="(report, index) in buttonData" :key="report.title" class="tab" :class="{
          'selected': currentTab === index,
          'dashed-border': currentTab !== index
        }" @click="selectTab(index)">
          <div class="daily-breakdown-button" :class="{
            'selected': currentTab === index,
            'dashed-border': currentTab !== index
          }">
            <VAvatar rounded size="38" :color="currentTab === index ? 'primary' : 'secondary'" variant="tonal"
              class="mb-1">
              <VIcon :icon="report.icon" />
            </VAvatar>
            <p class="mb-0" :style="{ textAlign: 'center' }">
              {{ report.title }}
            </p>
          </div>
        </div>
      </div>

      <VueApexCharts ref="refVueApexChart" :key="chartConfigs.key" :options="chartConfigs.chartOptions"
        :series="chartConfigs.series" height="240" class="mt-3" />
    </VCardText>
  </VCard>
</template>

<style scoped>
.tab {
  block-size: 110px;
  inline-size: 25%;
  padding-block: 0 10px;
  padding-inline: 10px;
}

.daily-breakdown-button {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 1px dashed #ccc;
  border-radius: 4px;
  block-size: 100%;
  cursor: pointer;
  inline-size: 100%;
  transition: border-color 0.3s;
}

.daily-breakdown-button.selected {
  border-color: rgb(var(--v-theme-primary)) !important;
}

.tab.selected {
  border-color: rgb(var(--v-theme-primary)) !important;
}

.tab.dashed-border {
  border-color: rgb(var(--v-theme-primary)) !important;

}
</style>
