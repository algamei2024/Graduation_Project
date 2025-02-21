import PropTypes from "prop-types";
import { Link, NavLink } from "react-router-dom";
import { XMarkIcon } from "@heroicons/react/24/outline";
import { DndProvider } from "react-dnd";
import { HTML5Backend } from "react-dnd-html5-backend";
import React, { useState, useEffect } from "react";

import Note from "./Note";

import {

  Button,
  IconButton,
  Typography,
} from "@material-tailwind/react";
import { useMaterialTailwindController, setOpenSidenav } from "@/context";
import routes from "@/routes";

const jsonData = {
  backgroundColor: 'red',
  textColor: '#333',
  borderColor: '#ccc'
  , width: '100px',
  height: "100px"
};

const dynamicStyles = `
  .button {
      background-color: ${jsonData.backgroundColor};
      color: ${jsonData.textColor};
      border: 1px solid ${jsonData.borderColor};
  }
  .img{
    width:100%;
    height:100%;
  }
  .a:link {
    color: red;
  }
  
  .a:visited {
    color: green;
  }
  

  .a:hover {
    color: hotpink;
  }
  

  .a:active {
    color: blue;
  }
`;

export function Sidenav() {


  const [controller, dispatch] = useMaterialTailwindController();
  const { sidenavColor, sidenavType, openSidenav } = controller;
  const sidenavTypes = {
    dark: "bg-gradient-to-br from-gray-800 to-gray-900",
    white: "bg-white shadow-sm",
    transparent: "bg-transparent",
  };
  const [notes, setNotes] = useState(true);

  const handleDrop = () => {

    setNotes(false);
  };

  const styleElement = document.createElement('style');
  styleElement.innerHTML = dynamicStyles;
  document.head.appendChild(styleElement);
  // console.log("routes.design", routes[0].design);
  return (

    <aside
      className={`${sidenavTypes[sidenavType]} ${openSidenav ? "translate-x-0" : "-translate-x-80"
        } fixed inset-0 z-50 my-4 ml-4 h-[calc(100vh-32px)] w-36 rounded-xl transition-transform duration-300 xl:translate-x-0 border border-blue-gray-100`}
    >
      <div
        className={`relative`}
      >
        <div className="py-6 px-8 text-center" >
          <Typography
            variant="h6"
            color={sidenavType === "dark" ? "white" : "blue-gray"}
          >
            العناصر
          </Typography>
        </div>
        <IconButton
          variant="text"
          color="white"
          size="sm"
          ripple={false}
          className="absolute right-0 top-0 grid rounded-br-none rounded-tl-none xl:hidden "
          onClick={() => setOpenSidenav(dispatch, false)}
        >
          <XMarkIcon strokeWidth={2.5} className="h-5 w-5 text-white" />
        </IconButton>
      </div>
      <div className="m-4">

        <DndProvider backend={HTML5Backend}  >
          {Object.keys(routes[0].design).map((key) => (

            <Note not={key} >  </Note>
          ))}





        </DndProvider>
      </div>
    </aside>
  );
}

Sidenav.defaultProps = {
  brandImg: "/img/logo-ct.png",
  brandName: "Material Tailwind React",
};

Sidenav.propTypes = {
  brandImg: PropTypes.string,
  brandName: PropTypes.string,
  routes: PropTypes.arrayOf(PropTypes.object).isRequired,
};

Sidenav.displayName = "/src/designer/widgets/layout/sidnave.jsx";

export default Sidenav;
