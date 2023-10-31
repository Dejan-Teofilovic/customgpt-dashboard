<script setup>
import arFlag from '@images/icons/countries/ag.png'
import anFlag from '@images/icons/countries/an.png'
import caFlag from '@images/icons/countries/ca.png'
import chFlag from '@images/icons/countries/ch.png'
import jaFlag from '@images/icons/countries/jr.png'
import paFlag from '@images/icons/countries/pk.png'
import poFlag from '@images/icons/countries/po.png'
import tkFlag from '@images/icons/countries/tk.png'
import usFlag from '@images/icons/countries/us.png'
import useGlobalStore from '../../../stores/globalStore'
import { ref, reactive } from 'vue'

const globalStore = useGlobalStore()

const salesByCountries = ref([
  {
    avatarImg: usFlag,
    stats: '$8,567k',
    subtitle: 'United States',
    // profitLoss: globalStore.userLocation['United States'] == null ? 0 : globalStore.userLocation['United States'],
    profitLoss: 0,
  },
  {
    avatarImg: tkFlag,
    stats: '$2,415k',
    subtitle: 'Turkey',
    profitLoss: 0,
  },
  {
    avatarImg: arFlag,
    stats: '$865k',
    subtitle: 'Argentina',
    profitLoss: 0,
  },
  {
    avatarImg: jaFlag,
    stats: '$745k',
    subtitle: 'Japan',
    profitLoss: 0,
  },
  {
    avatarImg: caFlag,
    stats: '$45',
    subtitle: 'Canada',
    profitLoss: 0,
  },
  {
    avatarImg: anFlag,
    stats: '$12k',
    subtitle: 'Angola',
    profitLoss: 0,
  },
  {
    avatarImg: chFlag,
    stats: '$12k',
    subtitle: 'China',
    profitLoss: 0,
  },
  {
    avatarImg: paFlag,
    stats: '$12k',
    subtitle: 'Pakistan',
    profitLoss: 0,
  },
  {
    avatarImg: poFlag,
    stats: '$12k',
    subtitle: 'Portugal',
    profitLoss: 0,
  },
])

watch(() => globalStore.userLocation, newTotalQuery => {
  const updatedStatistics = salesByCountries.value.map(stat => {
    stat.profitLoss = newTotalQuery[stat.subtitle]

    return stat
  })

  salesByCountries.value = Array.from(updatedStatistics)
})
</script>

<template>
  <VCard title="User Location" height="100%">
    <template #append>
      <div class="mt-n4 me-n2">
        <VBtn icon color="default" size="x-small" variant="plain" />
      </div>
    </template>

    <VCardText>
      <VList class="card-list">
        <VListItem v-for="country in salesByCountries" :key="country.stats">
          <template #prepend>
            <VAvatar size="34" color="secondary" variant="tonal" :image="country.avatarImg" />
          </template>

          <VListItemTitle class="font-weight-medium">
            <span :style="{ fontSize: '15px !important' }">{{ country.subtitle }}</span>
          </VListItemTitle>


          <template #append>
            <div class="d-flex align-center font-weight-semibold">
              {{ country.profitLoss }}
            </div>
          </template>
        </VListItem>
      </VList>
    </VCardText>
  </VCard>
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 19px;
}
</style>
