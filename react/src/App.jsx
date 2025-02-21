import { Routes, Route, Navigate } from "react-router-dom";
import Home from "./home";
import { Dashboard, Auth } from "@/layouts";
import RequiredAuth from "./auth/requiredAuth";
import RequiredBack from "./auth/requiredBack";
import UpdateUser from "./pages/dashboard/updateUser";
import CreateUser from "./pages/dashboard/createUser";
import StoreInformationTest from "./pages/storeInformationTest";
import Main from "./store_electronic/Main";
import Info from './store_electronic/InfoStore/Info';
import InfoLocation from "./store_electronic/Location/InfoLocation";
import ChooseStructure from "./store_electronic/structure/chooseStructure";
import RefreshPage from "./refreshPage/refreshPage";
import { ChangePassword } from "./pages/dashboard";
import TestGotoReact from "./store_electronic/testGotoReact";
import Designer from "./designer";
import styleElement from "./designer/pages/dashboard/styleElement";
import dargcss from "./designer/pages/dashboard/css";
import { useEffect } from "react";
import BackSignIn from "./auth/backSignIn";


const applyStylesFromJson = function (styles) {


  styleElement.type = 'text/css';
  let cssString = '';
  // Convert JSON to CSS string

  for (const selector in styles) {
    cssString += `${selector} { `;
    for (const property in styles[selector]) {
      cssString += `${property}: ${styles[selector][property]}; `;
    }
    cssString += `} `;

  }
  return cssString;
}

function App() {

  useEffect(() => {


    document.head.appendChild(styleElement);

    styleElement.innerHTML = applyStylesFromJson(dargcss);


  });

  return (
    <Routes>
      {/* <Route path="/" element={<Home />} />  */}
      <Route path="/goToDesigner" element={<Designer />} />
      {/* <Route path="/" element={<Designer />} /> */}


      <Route element={<BackSignIn />}>
        <Route path="/information" element={<Main />}>
          <Route path='/information' element={<Info />} />
          <Route path="structure" element={<ChooseStructure />} />
          <Route path='InfoLocation' element={<InfoLocation />} />
        </Route>
      </Route>

      <Route path='/store/information' element={<StoreInformationTest />} />
      <Route path='/gotoReact' element={<TestGotoReact />} />

      <Route element={<RefreshPage />}>
        <Route element={<RequiredAuth allowedRole={['admin', 'store']} />} >
          <Route path="/dashboard" element={<Dashboard />}>
            <Route path="*" />
            <Route path="tables/:id" element={<UpdateUser />} />
            <Route path="changePassword" element={<ChangePassword />} />
            <Route path="tables/createuser" element={<CreateUser />} />

          </Route>
          <Route path="*" element={<Navigate to="/dashboard/home" replace />} />
        </Route>
      </Route>

      <Route element={<RequiredBack />} >
        <Route path="/auth/*" element={<Auth />} />
      </Route>


    </Routes>
  );
}

export default App;
