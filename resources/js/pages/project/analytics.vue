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
        <VCard title="Users">
          <Piecharts :labels="piechartsLabels[0]" :series="piechartsSeries[0]" :key="0" />
        </VCard>
      </VCol>
      <VCol cols="3">
        <VCard title="Source">
          <Piecharts :labels="piechartsLabels[1]" :series="piechartsSeries[1]" :key="1" />
        </VCard>
      </VCol>
      <VCol cols="3">
        <VCard title="Browsers">
          <Piecharts :labels="piechartsLabels[2]" :series="piechartsSeries[2]" :key="2" />
        </VCard>
      </VCol>
      <VCol cols="3">
        <VCard title="Query Status">
          <Piecharts :labels="piechartsLabels[3]" :series="piechartsSeries[3]" :key="3" />
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
import { ref, onMounted, onUnmounted, watch } from 'vue'
//import useGlobalStore from '../..//stores/globalStore';
import useGlobalStore from '../../stores/globalStore';
// Import your components
import Barcharts from '@/views/project/analytics/Barcharts.vue'
import BarChartsDaily from '@/views/project/analytics/BarchartsDaily.vue'
import ConversationsCard from '@/views/project/analytics/ConversationsCard.vue'
import DailyBreakdownCard from '@/views/project/analytics/DailyBreakdownCard.vue'
import Piecharts from '@/views/project/analytics/Piecharts.vue'
import QueriesCard from '@/views/project/analytics/QueriesCard.vue'
import UserLocationCard from '@/views/project/analytics/UserLocationCard.vue'
import axiosIns from '../../plugins/axios'
import VueApexCharts from 'vue3-apexcharts';
import { reactive } from 'vue';

const globalStore = useGlobalStore();

// Watch for changes in the dateRange and fetch data when it changes
watch(() => globalStore.dateRange, (newDateRange, oldDateRange) => {
  if (newDateRange !== oldDateRange) {
    //globalStore.cancelAllApiCalls();
    globalStore.fetchAllData();
  }
});
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

const message = ref('Hello, Vue Composition API!')
const counter = ref(0)
const piechartsLabels = reactive([[], [], [], []])
const piechartsSeries = reactive([[], [], [], []])
// const piechartsLabels = ref([['choego1', 'choego2', 'choego3', 'choego4'], ['choego1', 'choego2', 'choego3', 'choego4'], ['choego1', 'choego2', 'choego3', 'choego4'], ['choego1', 'choego2', 'choego3', 'choego4']])
// const piechartsSeries = ref([[123, 432, 324, 421], [123, 432, 324, 421], [123, 432, 324, 421], [123, 432, 324, 421],])
function incrementCounter() {
  counter.value++
}

// Lifecycle hooks
onMounted(() => {
  //globalStore.cancelAllApiCalls();
  globalStore.fetchAllData();
}
)

onUnmounted(() => {
  console.log('Component unmounted')
})

watch(() => globalStore.barchartUsers, (newTotalQuery) => {
  const arr1 = Array.from(Object.keys(newTotalQuery));
  const arr2 = Array.from(Object.values(newTotalQuery));
  piechartsLabels[0] = arr1;
  piechartsSeries[0] = arr2;
  console.log("choegotest");
});
watch(() => globalStore.barchartSource, (newTotalQuery) => {
  const arr1 = Array.from(Object.keys(newTotalQuery));
  const arr2 = Array.from(Object.values(newTotalQuery));

  piechartsLabels[1] = arr1;
  piechartsSeries[1] = arr2;
  console.log("choegotest");
});
watch(() => globalStore.barchartBrowsers, (newTotalQuery) => {
  const arr1 = Array.from(Object.keys(newTotalQuery));
  const arr2 = Array.from(Object.values(newTotalQuery));

  piechartsLabels[2] = arr1;
  piechartsSeries[2] = arr2;
  console.log("choegotest");
});
watch(() => globalStore.barchartQueryStatus, (newTotalQuery) => {
  const arr1 = Array.from(Object.keys(newTotalQuery));
  const arr2 = Array.from(Object.values(newTotalQuery));

  piechartsLabels[3] = arr1;
  piechartsSeries[3] = arr2;
  console.log("choegotest");
});

</script>
