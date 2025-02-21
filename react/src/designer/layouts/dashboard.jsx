
import { Cog6ToothIcon } from "@heroicons/react/24/solid";
import Sidenav from '../../designer/widgets/layout/sidenav';
import DashboardNavbar from '../../designer/widgets/layout/dashboard-navbar';
import Configurator from '../../designer/widgets/layout/configurator';
import Home from '../../designer/pages/dashboard/home';
import routes from "@/routes";
import { useMaterialTailwindController, setOpenConfigurator } from "@/context";
import { useState } from "react";
import { useEffect } from "react";


export function Dashboard() {
  const [controller, dispatch] = useMaterialTailwindController();
  const { sidenavType } = controller;
  const [targ, settarg] = useState(null);
  function targ_css(targetElement) {
    settarg(targetElement)

    setOpenConfigurator(dispatch, true)
  }



  return (
    <div className="min-h-screen bg-blue-gray-50/50">
      {/* <Sidenav
        routes={routes}
        brandImg={
          sidenavType === "dark" ? "/img/logo-ct.png" : "/img/logo-ct-dark.png"
        }
      /> */}
      <div className="p-4 ">
        <DashboardNavbar />
        <Configurator targ={targ} />
      
        <Home targ_css={targ_css} />
        <div className="text-blue-gray-600">
          {/* <Footer /> */}
        </div>
      </div>
    </div>
  );
}

Dashboard.displayName = "/src/layout/dashboard.jsx";

export default Dashboard;
