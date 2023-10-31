import { breakpointsVuetify } from '@vueuse/core'
import { VIcon } from 'vuetify/components'

import { defineThemeConfig } from '@core'
import { RouteTransitions, Skins } from '@core/enums'

// ❗ Logo SVG must be imported with ?raw suffix
// import logo from '@images/logo.svg?raw'
import logo from '@images/logo_customchatgpt.svg?raw'

import { AppContentLayoutNav, ContentWidth, FooterType, NavbarType } from '@layouts/enums'

export const { themeConfig, layoutConfig } = defineThemeConfig({
  app: {
    title: 'CustomGPT.ai',
    logo: h('div', { innerHTML: logo, style: 'line-height:0; color: rgb(var(--v-global-theme-primary))' }),
    contentWidth: ContentWidth.Boxed,
    contentLayoutNav: AppContentLayoutNav.Vertical,
    overlayNavFromBreakpoint: breakpointsVuetify.md + 16,
    enableI18n: false,
    theme: 'light',
    isRtl: false,
    skin: Skins.Default,
    routeTransition: RouteTransitions.Fade,
    iconRenderer: VIcon,
  },
  navbar: {
    type: NavbarType.Sticky,
    navbarBlur: true,
  },
  footer: { type: FooterType.Static },
  verticalNav: {
    isVerticalNavCollapsed: false,
    defaultNavItemIconProps: { icon: 'tabler-circle', size: 10 },
    isVerticalNavSemiDark: false,
  },
  horizontalNav: {
    type: 'sticky',
    transition: 'slide-y-reverse-transition',
  },
  icons: {
    chevronDown: { icon: 'tabler-chevron-down' },
    chevronRight: { icon: 'tabler-chevron-right', size: 18 },
    close: { icon: 'tabler-x' },

    // verticalNavPinned: { icon: 'tabler-circle-dot' },
    // verticalNavUnPinned: { icon: 'tabler-circle' },

    verticalNavPinned: { icon: 'custom-indent-decrease' },
    verticalNavUnPinned: { icon: 'custom-indent-increase' },
    sectionTitlePlaceholder: { icon: 'tabler-separator' },
  },
})
