import { useContext } from "react";
import { storeInfo } from "@/context/info_store";
import { Navigate, Outlet } from "react-router-dom";
import { useLocation } from "react-router";
export default function BackSignIn() {
    const StoreInfo = useContext(storeInfo);
    const location = useLocation();

    return StoreInfo.info.name ? <Outlet /> : <Navigate state={{ from: location }} replace to='/auth/sign-up' />;
}