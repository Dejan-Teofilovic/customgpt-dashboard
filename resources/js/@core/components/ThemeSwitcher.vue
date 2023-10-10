<script setup>
import { useThemeConfig } from '@core/composable/useThemeConfig'

const props = defineProps({
  themes: {
    type: Array,
    required: true,
  },
})

const { theme } = useThemeConfig()

const {
  state: currentTheme,
  next: getNextThemeName,
  index: currentThemeIndex,
} = useCycleList(props.themes.map(t => t.name), { initialValue: theme.value })

const changeTheme = () => {
  theme.value = getNextThemeName()
}

const getThemeIcon = computedWithControl(theme, () => {
  const nextThemeIndex = currentThemeIndex.value + 1 === props.themes.length ? 0 : currentThemeIndex.value + 1
  
  return props.themes[nextThemeIndex].icon
})

watch(theme, val => {
  currentTheme.value = val
})
</script>

<template>
  <VBtn
    icon
    variant="text"
    color="default"
    size="small"
    @click="changeTheme"
  >
    <VIcon
      :icon="getThemeIcon"
      size="24"
    />
  </VBtn>
</template>
