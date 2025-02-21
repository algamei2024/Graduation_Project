// import React from 'react';



// console.log("one");
// export default function App(){
//   const [wajdi, setWajdi] = React.useState(true);
//   console.log(wajdi);

//   return (
//     <div onClick={()=>setWajdi((L)=>!L)}>
//       {wajdi?'true':'false'}
//     </div>
//   );
// }


// import { useState } from "react";
// export default function App(){
// const [firstName, setFName] = useState('');
// const [lastName, setLName] = useState('');
// const [email, setEmail] = useState('');

//   console.log(firstName);
//   console.log(lastName);
//   console.log(email);
//   return <div>
// <form>
//   <label htmlFor="1" >First Name:</label>
//   <input type='text' id='1' value={firstName} onChange={(e)=>setFName(e.target.value)} required placeholder='enter your first name' />
//   <label htmlFor="2" >Last Name:</label>
//   <input type='text' id='2' value={lastName} onChange={(e)=>setLName(e.target.value)} required placeholder='enter your last name' />
//   <label htmlFor="3" >Email:</label>
//   <input type='email' id='3' value={email} onChange={(e)=>setEmail(e.target.value)} required placeholder='enter your email' />
//   <button type='submit'>Submit</button>
// </form>
//   </div>;
// }


import { useState } from "react";
import MyComponent from "./component/myComponent";
import { FirstContext } from "./context/firstContext";
import { Route, Routes, Link, Switch, redirect } from 'react-router-dom';
import First from "./router/first";
import HomeStore from "./store_electronic/homeStore";
import ChooseStructure from "./store_electronic/structure/chooseStructure";
import HeaderBE from "./recieveFile/createHeader";
import RecieveHeader from "./recieveFile/recieveHeader";
import Footer from "./backend/frontend/layouts/footer";
import Header from "./backend/frontend/layouts/header";
import Login from "./backend/frontend/pages/login";
import Register from "./backend/frontend/pages/register";

import axios from "axios";
import RequiredAuth from "./auth/requiredAuth";
import DashBoard from "./fromFront_endProj/dashBoard";
import Users from './fromFront_endProj/users';
import CreateUser from './fromFront_endProj/createUser';
import UpdateUser from './fromFront_endProj/updateUser';
import RefreshPage from "./refreshPage/refreshPage";
import Err403 from "./auth/err403";
import Writer from "./backend/frontend/pages/writer";
import Err404 from "./auth/err404";
import Main from "./store_electronic/Main";
import Info from './store_electronic/InfoStore/Info';
import InfoLocation from "./store_electronic/Location/InfoLocation";
import Dash from "./Dashboard/Dash";

export default function App() {
  const [Name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [Password, setPassword] = useState('');
  const [CPassword, setCPassword] = useState('');
  const [accept, setAccept] = useState(false);

  // const [flag, setFlag] = useState(false);

  // console.log(flag);
  async function submit(e) {
    let flag = true;
    setAccept(true);
    e.preventDefault();
    if (Name === '' || Password.length < 8 || CPassword !== Password) {
      flag = false;
    } else {
      flag = true;
    }
    try {
      if (flag) {
        let res = await axios.post('http://127.0.0.1:8000/api/register',
          {
            name: Name,
            email: email,
            password: Password,
            password_conf: CPassword
          }).then((result) => console.log(result));
      }
    } catch (err) {
      console.log(err);
    }
  }



  function myFunctionHandleChange(event) {
    setName(event.target.value);
  }

  return <div className="father">
    {/* <HeaderBE />
    <RecieveHeader /> */}
    <Routes>
      <Route path="/" element={<Main />}>
        <Route path='/' element={<Info />} />
        <Route path="/structure" element={<ChooseStructure />} />
        <Route path='/InfoLocation' element={<InfoLocation />} />
      </Route>
      <Route path='Dash' element={<Dash />} />
      <Route path='/h' element={<HomeStore />} />
      <Route path='go/chooseStruct' element={<ChooseStructure />} />

      <Route path='go/register' element={<Register />} />
      <Route path='go/login' element={<Login />} />


      <Route element={<RefreshPage />} >

        {/* <Route path="error" element={<Err403 />} /> */}
        <Route path='go/footer' element={<Footer />} />
        <Route path='go/header' element={<Header />} />
        <Route path='/*' element={<Err404 />} />

        <Route element={<RequiredAuth allowedRole={['admin', 'user']} />} >
          <Route path='/dashBoard' element={<DashBoard />} >
            <Route element={<RequiredAuth allowedRole={['admin']} />} >
              <Route path='users' element={<Users />} />
              <Route path='create/user' element={<CreateUser />} />
              <Route path='users/:id' element={<UpdateUser />} />
              <Route path=':id' element={<UpdateUser />} />
            </Route>
            <Route element={<RequiredAuth allowedRole={['admin', 'user']} />}  >
              <Route path="writer" element={<Writer />} />
            </Route>
          </Route>
        </Route>

      </Route>
    </Routes>

    {/*     
    <form onSubmit={submit}>


      <FirstContext.Provider value={{
        Label: "title from context",
        handleFunction: myFunctionHandleChange,
        valueInput: Name
      }} >
        <MyComponent />
      </FirstContext.Provider>

      {Name.length < 1 && accept && <p className='error'>Name is required</p>}


      <label htmlFor="email" >Email:</label>
      <input type='email' id='email' required value={email} onChange={(e) => setEmail(e.target.value)} placeholder='enter your email' />

      <label htmlFor="pass" >Password</label>
      <input type='password' id='pass' value={Password} onChange={(e) => setPassword(e.target.value)} placeholder='enter your Password' />

      {Password.length < 8 && accept && <p className='error'>password must be length 8</p>}

      <label htmlFor="cpass" >Password confirm</label>
      <input type='password' id='cpass' value={CPassword} onChange={(e) => setCPassword(e.target.value)} placeholder='enter your Password confirm' />
      {(Password.length >= 8 && CPassword !== Password && accept) ? <p className='error'>password not equal</p> : ''}

      <button type='submit'>Submit</button>

      <br />
      <br />
      <hr />

      <div>

        <Link to='/home'>
          <button>Home</button>
        </Link>
        <Link to='services'>
          <button>Services</button>
        </Link>
        <Link to='contect_us'>
          <button>contect_us</button>
        </Link>
        <Link to='router/first'>
          <button>router</button>
        </Link>



      </div>

      <Routes>
        <Route path='/home/:1' element={<h1>Home</h1>} />
        <Route path='/services/:2' element={<h1>Services</h1>} />
        <Route path='/contect_us/:3' element={<h1>contect_us</h1>} />
        <Route exact path='/router/first/:myid' element={<First />} />
      </Routes>
    </form>
   */}
  </div>;
}

