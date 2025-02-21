import Cookie from 'cookie-universal';
import { Outlet } from "react-router";

export default function RequiredBack() {
    const cookie = Cookie();
    const token = cookie.get('Bearer');

    return token ? window.history.back() : <Outlet />;
}