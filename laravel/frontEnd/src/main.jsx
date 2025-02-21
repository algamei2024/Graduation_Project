import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'
import {BrowserRouter} from 'react-router-dom'

import './index.css'
import './css/app.css'


ReactDOM.createRoot(document.getElementById('root')).render(
    <BrowserRouter>
  <React.StrictMode>

    <App />

  </React.StrictMode>,
  </BrowserRouter>
)
