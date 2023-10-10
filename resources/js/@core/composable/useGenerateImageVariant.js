import { useThemeConfig } from '@core/composable/useThemeConfig'

const { theme, skin } = useThemeConfig()

// composable function to return the image variant as per the current theme and skin
export const useGenerateImageVariant = (imgLight, imgDark, imgLightBordered, imgDarkBordered, bordered = false) => {
  return computed(() => {
    if (theme.value === 'light') {
      if (skin.value === 'bordered' && bordered)
        return imgLightBordered
      else
        return imgLight
    }
    else {
      if (skin.value === 'bordered' && bordered)
        return imgDarkBordered
      else
        return imgDark
    }
  })
}
