import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue({
    template: {
      compilerOptions: {
        // whereby web componentsをカスタム要素として扱うよう指定
        isCustomElement: (tag: any) => tag.includes('whereby-embed')
      }
    }
  })],
})
