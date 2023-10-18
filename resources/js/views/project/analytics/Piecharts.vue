<!-- <script setup>
import { getDonutChartConfig } from '@core/libs/apex-chart/apexCharConfig'
import VueApexCharts from 'vue3-apexcharts'
import { useTheme } from 'vuetify'
import useGlobalStore from '../../../stores/globalStore';
import { ref, reactive } from 'vue';

const reftest = ref();
const keyThis = Date.now();
const props = defineProps(['labels', 'series', 'key'])
const globalStore = useGlobalStore();
const vuetifyTheme = useTheme()
const expenseRationChartConfig = computed(() => getDonutChartConfig(vuetifyTheme.current.value, props.labels))

// const series = [
//   85,
//   16,
//   50,
// ]

</script>

<template>
  <VueApexCharts type="donut" height="410" :key="keyThis" :options="expenseRationChartConfig" :series="props.series" />
</template> -->



<template>
  <div>
    <apexchart type="donut" :options="chartOptions" :series="chartData"></apexchart>
  </div>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts';
import { getDonutChartConfig } from '@core/libs/apex-chart/apexCharConfig'
import { useTheme } from 'vuetify'
import { hexToRgb } from '@layouts/utils'


// 👉 Colors variables
const colorVariables = themeColors => {
  const themeSecondaryTextColor = `rgba(${hexToRgb(themeColors.colors['on-surface'])},${themeColors.variables['medium-emphasis-opacity']})`
  const themeDisabledTextColor = `rgba(${hexToRgb(themeColors.colors['on-surface'])},${themeColors.variables['disabled-opacity']})`
  const themeBorderColor = `rgba(${hexToRgb(String(themeColors.variables['border-color']))},${themeColors.variables['border-opacity']})`
  const themePrimaryTextColor = `rgba(${hexToRgb(themeColors.colors['on-surface'])},${themeColors.variables['high-emphasis-opacity']})`

  return { themeSecondaryTextColor, themeDisabledTextColor, themeBorderColor, themePrimaryTextColor }
}

export default {
  components: {
    apexchart: VueApexCharts,
  },
  props: {
    series: {
      type: Array,
      required: true,
    },
    labels: {
      type: Array,
      required: true,
    },
  },
  computed: {
    chartData() {
      return this.series;
    },
    chartOptions() {
      const donutColors = {
        series1: '#fdd835',
        series2: '#00d4bd',
        series3: '#826bf8',
        series4: '#32baff',
        series5: '#ffa1a1',
      }
      return {
        labels: this.labels,
        stroke: { width: 0 },
        colors: [donutColors.series1, donutColors.series5, donutColors.series3, donutColors.series2],
        dataLabels: {
          enabled: true,
          formatter: val => `${parseInt(val, 10)}%`,
        },
        legend: {
          position: 'bottom',
          markers: { offsetX: -3 },
          labels: { colors: donutColors.series1 },
          itemMargin: {
            vertical: 3,
            horizontal: 10,
          },
          plotOptions: {
            pie: {
              donut: {
                labels: {
                  show: true,
                  name: {
                    fontSize: '1.5rem',
                  },
                  value: {
                    fontSize: '1.5rem',
                    color: donutColors.series1,
                    formatter: val => `${parseInt(val, 10)}`,
                  },
                  total: {
                    show: true,
                    fontSize: '1.5rem',
                    label: 'Operational',
                    formatter: () => '31%',
                    color: donutColors.series1,
                  },
                },
              },
            },
          },
          responsive: [
            {
              breakpoint: 992,
              options: {
                chart: {
                  height: 380,
                },
                legend: {
                  position: 'bottom',
                },
              },
            },
            {
              breakpoint: 576,
              options: {
                chart: {
                  height: 320,
                },
                plotOptions: {
                  pie: {
                    donut: {
                      labels: {
                        show: true,
                        name: {
                          fontSize: '1rem',
                        },
                        value: {
                          fontSize: '1rem',
                        },
                        total: {
                          fontSize: '1rem',
                        },
                      },
                    },
                  },
                },
              },
            },
          ],
        },
      }
    }
  }
}
</script>
