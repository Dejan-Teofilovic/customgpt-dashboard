<template>
  <div key="transition_id4">
    <QueriesCard />
    <ConversationsCard />
    <!-- 👉 Earning Reports -->
    <div :style="{ marginTop: '16px' }" />
    <VRow>
      <VCol cols="12" md="7">
        <DailyBreakdownCard />
      </VCol>
      <VCol cols="12" md="5">
        <UserLocationCard />
      </VCol>
    </VRow>
    <VRow>
      <VCol cols="3">
        <VCard title="Users" :style="{ height: '100%' }">
          <Piecharts :key="0" :labels="piechartsLabels[0]" :series="piechartsSeries[0]" title="Users" />
        </VCard>
      </VCol>
      <VCol cols="3">
        <VCard title="Source" :style="{ height: '100%' }">
          <Piecharts :key="1" :labels="piechartsLabels[1]" :series="piechartsSeries[1]" title="Source" />
        </VCard>
      </VCol>
      <VCol cols="3">
        <VCard title="Browsers" :style="{ height: '100%' }">
          <Piecharts :key="2" :labels="piechartsLabels[2]" :series="piechartsSeries[2]" title="Browsers" />
        </VCard>
      </VCol>
      <VCol cols="3">
        <VCard title="Query Status" :style="{ height: '100%' }">
          <Piecharts :key="3" :labels="piechartsLabels[3]" :series="piechartsSeries[3]" title="Query Status" />
        </VCard>
      </VCol>
    </VRow>
    <VRow title="Total Queries">
      <VCol cols="6">
        <Barcharts :colors="chartJsCustomColors" />
      </VCol>
      <VCol cols="6">
        <BarChartsDaily :colors="chartJsCustomColors" />
      </VCol>
    </VRow>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, reactive } from 'vue'

//import useGlobalStore from '../..//stores/globalStore';
import useGlobalStore from '../../stores/globalStore'

// Import your components
import Barcharts from '@/views/project/analytics/Barcharts.vue'
import BarChartsDaily from '@/views/project/analytics/BarchartsDaily.vue'
import ConversationsCard from '@/views/project/analytics/ConversationsCard.vue'
import DailyBreakdownCard from '@/views/project/analytics/DailyBreakdownCard.vue'
import Piecharts from '@/views/project/analytics/Piecharts.vue'
import QueriesCard from '@/views/project/analytics/QueriesCard.vue'
import UserLocationCard from '@/views/project/analytics/UserLocationCard.vue'
import Echo from "laravel-echo";
import axiosIns from '../../plugins/axios'
import VueApexCharts from 'vue3-apexcharts'

const globalStore = useGlobalStore()

window.Echo.channel('my-channel')
  .listen('MyEvent', (data) => {
    console.log(data)
    if (globalStore[data.setter]) {
      globalStore[data.setter](data.result);
    } else {
      console.error(`Function ${data.setter} not found in globalStore.`);
    }
    // Handle the real-time data here.
  });

// Watch for changes in the dateRange and fetch data when it changes
watch(() => globalStore.dateRange, (newDateRange, oldDateRange) => {
  if (newDateRange !== oldDateRange) {
    globalStore.fetchAllData()
  }
})

const chartJsCustomColors = {
  white: '#fff',
  yellow: '#ffe802',
  primary: '#836af9',
  areaChartBlue: '#2c9aff',
  barChartYellow: '#ffcf5c',
  polarChartGrey: '#4f5d70',
  polarChartInfo: '#299aff',
  lineChartYellow: '#d4e157',
  polarChartGreen: '#28dac6',
  lineChartPrimary: '#9e69fd',
  lineChartWarning: '#ff9800',
  horizontalBarInfo: '#26c6da',
  polarChartWarning: '#ff8131',
  scatterChartGreen: '#28c76f',
  warningShade: '#ffbd1f',
  areaChartBlueLight: '#84d0ff',
  areaChartGreyLight: '#edf1f4',
  scatterChartWarning: '#ff9f43',
}

const piechartsLabels = reactive([[], [], [], []])
const piechartsSeries = reactive([[], [], [], []])

// Lifecycle hooks
onMounted(() => {
  globalStore.fetchAllData()

  //NOTE - Listen the proper port for broadcasting in laravel
  // window.Echo.channel("dashboard")
  //   .listen("testevent", (e) => {
  //     debugger
  //     messages.push(e.message);
  //   });

}
)

onUnmounted(() => {
  console.log('Component unmounted')
})

watch(() => globalStore.barchartUsers, newTotalQuery => {
  const arr1 = Array.from(Object.keys(newTotalQuery))
  const arr2 = Array.from(Object.values(newTotalQuery))

  piechartsLabels[0] = arr1
  piechartsSeries[0] = arr2

})

watch(() => globalStore.barchartSource, newTotalQuery => {
  const arr1 = Array.from(Object.keys(newTotalQuery))
  const arr2 = Array.from(Object.values(newTotalQuery))

  piechartsLabels[1] = arr1
  piechartsSeries[1] = arr2
})

watch(() => globalStore.barchartBrowsers, newTotalQuery => {
  const arr1 = Array.from(Object.keys(newTotalQuery))
  const arr2 = Array.from(Object.values(newTotalQuery))

  piechartsLabels[2] = arr1
  piechartsSeries[2] = arr2
})

watch(() => globalStore.barchartQueryStatus, newTotalQuery => {
  const arr1 = Array.from(Object.keys(newTotalQuery))
  const arr2 = Array.from(Object.values(newTotalQuery))

  piechartsLabels[3] = arr1
  piechartsSeries[3] = arr2
})

//!SECTION This is the section for broadcasting with laravel + vue
const messages = ref([])
const newMessage = ref("");

const sendMessage = () => {
  axiosIns.post("/send", { message: this.newMessage });
  this.newMessage = "";
}
</script>
