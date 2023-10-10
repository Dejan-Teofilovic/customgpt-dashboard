<script setup>
import { hexToRgb } from '@layouts/utils'
import VueApexCharts from 'vue3-apexcharts'
import { useTheme } from 'vuetify'

const vuetifyTheme = useTheme()
const currentTab = ref(0)
const refVueApexChart = ref()

const selectTab = index => {
  currentTab.value = index
}

const addTab = () => {
  // Logic to add a new tab
}

const chartConfigs = computed(() => {
  const currentTheme = vuetifyTheme.current.value.colors
  const variableTheme = vuetifyTheme.current.value.variables
  const labelPrimaryColor = `rgba(${ hexToRgb(currentTheme.primary) },${ variableTheme['dragged-opacity'] })`
  const legendColor = `rgba(${ hexToRgb(currentTheme['on-background']) },${ variableTheme['high-emphasis-opacity'] })`
  const borderColor = `rgba(${ hexToRgb(String(variableTheme['border-color'])) },${ variableTheme['border-opacity'] })`
  const labelColor = `rgba(${ hexToRgb(currentTheme['on-surface']) },${ variableTheme['disabled-opacity'] })`
  
  

  return [
    {
      title: 'Queries',
      icon: 'tabler-question-mark',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
          28,
          10,
          45,
          38,
          15,
          30,
          35,
          30,
          8,
        ],
      }],
    },
    {
      title: 'Response Start Time',
      icon: 'tabler-clock',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
          labelPrimaryColor,
          labelPrimaryColor,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
              grid: { padding: { right: 0 } },
              dataLabels: {
                style: {
                  fontSize: '12px',
                  fontWeight: '400',
                },
              },
              yaxis: { labels: { show: false } },
            },
          },
        ],
      },
      series: [{
        data: [
          35,
          25,
          15,
          40,
          42,
          25,
          48,
          8,
          30,
        ],
      }],
    },
    {
      title: 'Response End Time',
      icon: 'tabler-clock',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
              grid: { padding: { right: 0 } },
              dataLabels: {
                style: {
                  fontSize: '12px',
                  fontWeight: '400',
                },
              },
              yaxis: { labels: { show: false } },
            },
          },
        ],
      },
      series: [{
        data: [
          10,
          22,
          27,
          33,
          42,
          32,
          27,
          22,
          8,
        ],
      }],
    },
    {
      title: 'Input Words',
      icon: 'tabler-letter-a',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
              plotOptions: { bar: { columnWidth: '50%' } },
              dataLabels: {
                style: {
                  fontSize: '12px',
                  fontWeight: '400',
                },
              },
              grid: { padding: { right: 0 } },
              yaxis: { labels: { show: false } },
            },
          },
        ],
      },
      series: [{
        data: [
          5,
          9,
          12,
          18,
          20,
          25,
          30,
          36,
          48,
        ],
      }],
    },
    {
      title: 'Output Words',
      icon: 'tabler-letter-a',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
          28,
          10,
          45,
          38,
          15,
          30,
          35,
          30,
          8,
        ],
      }],
    },
    {
      title: 'Conversations',
      icon: 'tabler-message',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
          labelPrimaryColor,
          labelPrimaryColor,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
              grid: { padding: { right: 0 } },
              dataLabels: {
                style: {
                  fontSize: '12px',
                  fontWeight: '400',
                },
              },
              yaxis: { labels: { show: false } },
            },
          },
        ],
      },
      series: [{
        data: [
          35,
          25,
          15,
          40,
          42,
          25,
          48,
          8,
          30,
        ],
      }],
    },
    {
      title: 'Queries Per Conversation',
      icon: 'tabler-question-mark',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
              grid: { padding: { right: 0 } },
              dataLabels: {
                style: {
                  fontSize: '12px',
                  fontWeight: '400',
                },
              },
              yaxis: { labels: { show: false } },
            },
          },
        ],
      },
      series: [{
        data: [
          10,
          22,
          27,
          33,
          42,
          32,
          27,
          22,
          8,
        ],
      }],
    },
    {
      title: 'Conversation Time',
      icon: 'tabler-chart-pie-2',
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
        colors: [
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          labelPrimaryColor,
          currentTheme.primary,
        ],
        dataLabels: {
          enabled: true,
          formatter(val) {
            return `${ val }k`
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
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
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
              return `${ parseInt(val / 1) }k`
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
              plotOptions: { bar: { columnWidth: '50%' } },
              dataLabels: {
                style: {
                  fontSize: '12px',
                  fontWeight: '400',
                },
              },
              grid: { padding: { right: 0 } },
              yaxis: { labels: { show: false } },
            },
          },
        ],
      },
      series: [{
        data: [
          5,
          9,
          12,
          18,
          20,
          25,
          30,
          36,
          48,
        ],
      }],
    },
  ]
})
</script>

<template>
  <VCard
    title="Daily Breakdown"
    subtitle="Last 7 days"
  >
    <template #append>
      <div class="mt-n4 me-n2">
        <VBtn
          icon
          size="x-small"
          variant="plain"
          color="default"
        />
      </div>
    </template>

    <VCardText>
      <div :style="{display:'flex', flexWrap:'wrap'}">
        <div
          v-for="(report, index) in chartConfigs"
          :key="report.title"
          class="tab"
          :class="{
            'selected': currentTab === index,
            'dashed-border': currentTab !== index
          }"
          @click="selectTab(index)"
        >
          <div class="daily-breakdown-button">
            <VAvatar
              rounded
              size="38"
              :color="currentTab === index ? 'primary' : 'secondary'"
              variant="tonal"
              class="mb-1"
            >
              <VIcon :icon="report.icon" />
            </VAvatar>
            <p
              class="mb-0"
              :style="{textAlign:'center'}"
            >
              {{ report.title }}
            </p>
          </div>
        </div>
      </div>

      <VueApexCharts
        ref="refVueApexChart"
        :key="currentTab"
        :options="chartConfigs[Number(currentTab)].chartOptions"
        :series="chartConfigs[Number(currentTab)].series"
        height="240"
        class="mt-3"
      />
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
</style>
