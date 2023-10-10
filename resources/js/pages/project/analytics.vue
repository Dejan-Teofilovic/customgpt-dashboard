
<template>
  <QueriesCard />
  <ConversationsCard />
  <!-- 👉 Earning Reports -->
  <div :style="{marginTop:'16px'}" />
  <VRow>
    <VCol
      cols="12"
      md="7"
    >
      <DailyBreakdownCard />
    </VCol>
    <VCol
      cols="12"
      md="5"
    >
      <UserLocationCard />
    </VCol>
  </VRow>
  <VRow>
    <VCol cols="3">
      <VCard title="Users">
        <Piecharts />
      </VCard>
    </VCol>
    <VCol cols="3">
      <VCard title="Source">
        <Piecharts />
      </VCard>
    </VCol>
    <VCol cols="3">
      <VCard title="Browsers">
        <Piecharts />
      </VCard>
    </VCol>
    <VCol cols="3">
      <VCard title="Query Status">
        <Piecharts />
      </VCard>
    </VCol>
  </VRow>
  <VRow title="Total Queries">
    <VCol cols="6">
      <Barcharts :colors="chartJsCustomColors" />
    </VCol>
    <VCol cols="6">
      <Barcharts :colors="chartJsCustomColors" />
    </VCol>
  </VRow>
</template>

<script setup>
import Barcharts from '@/views/project/analytics/Barcharts.vue'
import ConversationsCard from '@/views/project/analytics/ConversationsCard.vue'
import DailyBreakdownCard from '@/views/project/analytics/DailyBreakdownCard.vue'
import Piecharts from '@/views/project/analytics/Piecharts.vue'
import QueriesCard from '@/views/project/analytics/QueriesCard.vue'
import UserLocationCard from '@/views/project/analytics/UserLocationCard.vue'

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
</script>
