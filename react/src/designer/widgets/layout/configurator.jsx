import React from "react";
import { XMarkIcon } from "@heroicons/react/24/outline";
import {
  Button,
  IconButton,
  Switch,
  Typography,
  Chip,
} from "@material-tailwind/react";
import {
  useMaterialTailwindController,
  setOpenConfigurator,

} from "@/context";

import Basic from "../../ElementsStyle/Basic";
import { useState } from "react";
import { useEffect } from "react";
function formatNumber(number, decPlaces) {
  decPlaces = Math.pow(10, decPlaces);

  const abbrev = ["K", "M", "B", "T"];

  for (let i = abbrev.length - 1; i >= 0; i--) {
    var size = Math.pow(10, (i + 1) * 3);

    if (size <= number) {
      number = Math.round((number * decPlaces) / size) / decPlaces;

      if (number == 1000 && i < abbrev.length - 1) {
        number = 1;
        i++;
      }

      number += abbrev[i];

      break;
    }
  }

  return number;
}

// export  function targ_css(event) {


// settarg(event.target)
// }


export function Configurator({ targ }) {
  const [controller, dispatch] = useMaterialTailwindController();
  const { openConfigurator } = controller;
  const [newtarg, setnewtarg] = useState()

  // useEffect(()=>{

  //   setnewtarg(targ); 
  //    console.log(newtarg)
  // },targ)







  return (
    <aside
      className={`fixed top-0 right-0  h-screen w-96 bg-white px-2.5 shadow-lg transition-transform duration-300 overflow-auto z-[3000] ${openConfigurator ? "translate-x-0" : "translate-x-96"
        }`} z
    >
      <div className="flex items-start justify-between px-6 pt-8 pb-6">
        <IconButton
          variant="text"
          color="blue-gray"
          onClick={() => setOpenConfigurator(dispatch, false)}
        >
          <XMarkIcon strokeWidth={2.5} className="h-5 w-5" />
        </IconButton>
        <Typography variant="h5" color="blue-gray">
          خصائص العناصر
        </Typography>

      </div>


      {openConfigurator ? <Basic target={targ} /> : ""}


    </aside>
  );
}

Configurator.displayName = "/src/widgets/layout/configurator.jsx";

export default Configurator;
