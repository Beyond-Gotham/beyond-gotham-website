import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// IONOS: Demo unter https://beyond-gotham.com/infoterminal/demo/
export default defineConfig({
  plugins: [react()],
  base: '/infoterminal/demo/'
})
