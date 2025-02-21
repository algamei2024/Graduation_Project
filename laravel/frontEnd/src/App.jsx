import { useEffect, useState } from 'react'
import Apptow  from './layout/app';
import Footer from './backend/layout/footer';
import Sidebar from './backend/layout/sidebar';
import { Routes, Route } from 'react-router-dom';
// import reactLogo from './assets/react.svg'
// import viteLogo from '/vite.svg'
import './App.css'

function App() {
//   const dataElement = document.getElementById('mytitle');
//   dataElement.textContent = "new title";
//   console.log(dataElement);
const[data, setData] = useState(null);

// async function getTitle(){
//     await fetch('http://127.0.0.1:8000/api/newtitle')
//     .then(response => response.json())
//     .then(data => setData(data))
//     .catch(error => console.error('Error fetching data:', error));
// }
const fetchData = async () => {
    try {
        const response = await fetch('http://127.0.0.1:8000/api/newtitle');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching data:', error);
        return null;
    }
};

useEffect(() => {
    const getData = async () => {
        const fetchedData = await fetchData();
        if (fetchedData) {
            setData(fetchedData);
        }
    };

    getData();
}, []);
    console.log('data is : ',data)

  return (
    <>
        <Apptow />
        <Routes>
            <Route path='Home' element={<Apptow/>}/>
        </Routes>
        <Sidebar/>
        <div>welcome</div>
        <h1>{data}</h1>
        <Footer />
    </>
  )
}

export default App
