import React from 'react'
import { createRoot } from 'react-dom/client'

function App(){
  return (
    <div style={{padding:16}}>
      <h1>InfoTerminal Demo</h1>
      <p>Tabs: Search | Graph | Map | Timeline (Platzhalter)</p>
    </div>
  )
}

createRoot(document.getElementById('root')!).render(<App />)
