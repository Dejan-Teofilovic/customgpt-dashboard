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

const salesByCountries = [
  {
    avatarImg: usFlag,
    stats: '$8,567k',
    subtitle: 'United states',
    profitLoss: 25.8,
  },
  {
    avatarImg: tkFlag,
    stats: '$2,415k',
    subtitle: 'Turkey',
    profitLoss: -6.2,
  },
  {
    avatarImg: arFlag,
    stats: '$865k',
    subtitle: 'Argentina',
    profitLoss: 12.4,
  },
  {
    avatarImg: jaFlag,
    stats: '$745k',
    subtitle: 'Japan',
    profitLoss: -11.9,
  },
  {
    avatarImg: caFlag,
    stats: '$45',
    subtitle: 'Canada',
    profitLoss: 16.2,
  },
  {
    avatarImg: anFlag,
    stats: '$12k',
    subtitle: 'Angola',
    profitLoss: 14.8,
  },
  {
    avatarImg: chFlag,
    stats: '$12k',
    subtitle: 'China',
    profitLoss: 14.8,
  },
  {
    avatarImg: paFlag,
    stats: '$12k',
    subtitle: 'Pakistan',
    profitLoss: 14.8,
  },
  {
    avatarImg: poFlag,
    stats: '$12k',
    subtitle: 'Portugal',
    profitLoss: 14.8,
  },
]
</script>

<template>
  <VCard
    title="User Location"
    height="100%"
  >
    <template #append>
      <div class="mt-n4 me-n2">
        <VBtn
          icon
          color="default"
          size="x-small"
          variant="plain"
        />
      </div>
    </template>

    <VCardText>
      <VList class="card-list">
        <VListItem
          v-for="country in salesByCountries"
          :key="country.stats"
        >
          <template #prepend>
            <VAvatar
              size="34"
              color="secondary"
              variant="tonal"
              :image="country.avatarImg"
            />
          </template>

          <VListItemTitle class="font-weight-medium">
            <span :style="{fontSize:'15px !important'}">{{ country.subtitle }}</span>
          </VListItemTitle>
          

          <template #append>
            <div class="d-flex align-center font-weight-semibold">
              3000
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
