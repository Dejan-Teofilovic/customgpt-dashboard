<script setup>
import BarChart from '@/@core/libs/chartjs/components/BarChart'
import { getLatestBarChartConfig } from '@core/libs/chartjs/chartjsConfig'
import { useTheme } from 'vuetify'
import useGlobalStore from '../../../stores/globalStore';
import { ref, reactive } from "vue";
const globalStore = useGlobalStore();
const props = defineProps({
  colors: {
    type: null,
    required: true,
  },
})

const vuetifyTheme = useTheme()
const chartOptions = computed(() => getLatestBarChartConfig(vuetifyTheme.current.value))

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

watch(() => globalStore.totalQueryDaily, (newTotalQuery) => {
  data.labels = Array.from(Object.keys(newTotalQuery));
  data.datasets[0].data = Array.from(Object.values(newTotalQuery));

});

</script>

<template>
  <BarChart :height="400" :chart-data="data" key="keytest2" :chart-options="chartOptions" />
</template>
