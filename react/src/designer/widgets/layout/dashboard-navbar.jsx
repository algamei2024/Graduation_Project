import { useLocation, Link } from "react-router-dom";
import {
  Navbar,

  IconButton,
  Breadcrumbs,
  
  
} from "@material-tailwind/react";
import {


  TvIcon,
  DevicePhoneMobileIcon

} from "@heroicons/react/24/solid";
import {
  useMaterialTailwindController,

} from "@/context";
import { useState,useEffect } from "react";
 export const new_window={phone:false,lab:false} ;
export function DashboardNavbar() {
  const [controller, dispatch] = useMaterialTailwindController();
  const { fixedNavbar, openSidenav } = controller;
  const { pathname } = useLocation();
  const [layout, page] = pathname.split("/").filter((el) => el !== "");
  const[_window,set_window]=useState({phone:0,lab:1})
  useEffect(()=>{
 let window_width=window.innerWidth;
 if(window_width>800){
  set_window({phone:false,lab:true})
  console.log(window_width)
}else{
  setscreen({phone:true,lab:false})
}
},0)
new_window.lab=_window.lab;
new_window.phone=_window.phone;
  return (
    <Navbar
      color={fixedNavbar ? "white" : "transparent"}
      className={`rounded-xl transition-all right-8 
           "sticky top-4 z-40 py-3 shadow-md shadow-blue-gray-500/5  bg-white   "
      }`}
      fullWidth
      blurred={fixedNavbar}
    >
      <div className="flex flex-col-reverse justify-between gap-6 md:flex-row md:items-center">
        <div className="capitalize">
          <Breadcrumbs
            className={`bg-transparent p-0 transition-all ${
              fixedNavbar ? "mt-1" : ""
            }`}
          >
              
            
            
          </Breadcrumbs>
        
        </div>
        <div className="flex items-center  w-full" style={{justifyContent:"center"}}>
        
        
        
          
            <div className="mx-2">
              <IconButton variant="text" color="blue-gray"
                className={`${_window.lab?"lab_pho":""}`}
                onClick={()=>{set_window({phone:false,lab:true});
                
                
                document.getElementById("this").style.width="1024px"}}
              >
                <TvIcon className="h-5 w-5 text-blue-gray-500  " />
              </IconButton>
        </div>
          
          <div className="mx-2" >
          <IconButton
            variant="text"
            color="blue-gray"
            
            className={`${_window.phone?"lab_pho":""}`}
            onClick={()=>{set_window({phone:true,lab:false});document.getElementById("this").style.width="400px"}}
          
          >
            <DevicePhoneMobileIcon className="h-5 w-5 text-blue-gray-500 " />
          </IconButton></div>
        </div>
      </div>
    </Navbar>
  );
}

DashboardNavbar.displayName = "/src/widgets/layout/dashboard-navbar.jsx";

export default DashboardNavbar;
