import { themeConfig } from '@themeConfig'

const theme = {
  defaultTheme: localStorage.getItem(`${themeConfig.app.title}-theme`) || themeConfig.app.theme.value,
  themes: {
    light: {
      dark: false,
      colors: {
        'primary': localStorage.getItem(`${themeConfig.app.title}-lightThemePrimaryColor`) || '#7367F0',
        'on-primary': '#fff',
        'secondary': '#A8AAAE',
        'on-secondary': '#fff',
        'success': '#28C76F',
        'on-success': '#fff',
        'info': '#00CFE8',
        'on-info': '#fff',
        'warning': '#FF9F43',
        'on-warning': '#fff',
        'error': '#EA5455',
        'background': '#F8F7FA',
        'on-background': '#33303C',
        'on-surface': '#33303C',
        'grey-50': '#FAFAFA',
        'grey-100': '#F5F5F5',
        'grey-200': '#EEEEEE',
        'grey-300': '#E0E0E0',
        'grey-400': '#BDBDBD',
        'grey-500': '#9E9E9E',
        'grey-600': '#757575',
        'grey-700': '#616161',
        'grey-800': '#424242',
        'grey-900': '#212121',
        'perfect-scrollbar-thumb': '#DBDADE',
      },
      variables: {
        'border-color': '#4B465C',
        'medium-emphasis-opacity': 0.68,

        // Shadows
        'shadow-key-umbra-opacity': 'rgba(var(--v-theme-on-surface), 0.03)',
        'shadow-key-penumbra-opacity': 'rgba(var(--v-theme-on-surface), 0.02)',
        'shadow-key-ambient-opacity': 'rgba(var(--v-theme-on-surface), 0.01)',
      },
    },
    dark: {
      dark: true,
      colors: {
        'primary': localStorage.getItem(`${themeConfig.app.title}-darkThemePrimaryColor`) || '#7367F0',
        'on-primary': '#fff',
        'secondary': '#A8AAAE',
        'on-secondary': '#fff',
        'success': '#28C76F',
        'on-success': '#fff',
        'info': '#00CFE8',
        'on-info': '#fff',
        'warning': '#FF9F43',
        'on-warning': '#fff',
        'error': '#EA5455',
        'background': '#25293C',
        'on-background': '#E4E6F4',
        'surface': '#2F3349',
        'on-surface': '#E4E6F4',
        'grey-50': '#26293A',
        'grey-100': '#2F3349',
        'grey-200': '#26293A',
        'grey-300': '#4A5072',
        'grey-400': '#5E6692',
        'grey-500': '#7983BB',
        'grey-600': '#AAB3DE',
        'grey-700': '#B6BEE3',
        'grey-800': '#CFD3EC',
        'grey-900': '#E7E9F6',
        'perfect-scrollbar-thumb': '#4A5072',
      },
      variables: {
        'border-color': '#CFD3EC',
        'medium-emphasis-opacity': 0.68,

        // Shadows
        'shadow-key-umbra-opacity': 'rgba(12, 16, 27, 0.15)',
        'shadow-key-penumbra-opacity': 'rgba(12, 16, 27, 0.01)',
        'shadow-key-ambient-opacity': 'rgba(12, 16, 27, 0.08)',
      },
    },
  },
}

export default theme
