import { defineConfig } from 'vitepress'

export default defineConfig({
  title: 'StreetSignal Platform',
  description: 'Complete documentation for the StreetSignal Platform',
  base: '/docs/',
  
  // Ignore dead links during build
  ignoreDeadLinks: true,
  
  themeConfig: {
    logo: '/logo-hz.png',
    
    nav: [
      { text: 'Home', link: '/' }
    ],

    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'Overview', link: '/' }
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/streetsignal/platform' }
    ],

    footer: {
      message: 'Released under the AGPL-3.0 License.',
      copyright: 'Copyright © 2025 StreetSignal Team'
    }
  }
})