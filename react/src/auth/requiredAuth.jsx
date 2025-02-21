import { useContext, useEffect, useState } from "react";
import { user } from "../context/dataUser";
import { Outlet, Navigate, useNavigate } from "react-router";
import { useLocation } from "react-router";
import axios from "axios";
import Loading from "../refreshPage/loading";
import Err403 from "./err403";
import Cookie from 'cookie-universal';
export default function RequiredAuth({ allowedRole }) {

    const [userT, setUserT] = useState('');

    const nav = useNavigate();
    const location = useLocation();


    const userTest = useContext(user);
    const cookie = Cookie();
    const token = cookie.get('Bearer');


    useEffect(() => {
        const userToken = async () => {
            await axios.get('http://127.0.0.1:8000/api/admin/tokenIsFound', {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }).then(data => {
                setUserT(data.data.user);

                console.log('data TokenisFound', data);
                // console.log('data token', data.data.token);
            }).catch((er) => {
                // nav('/auth/sign-in', { replace: true });
                console.log('error form token is founded', er);
            });
        };

        userToken();
    }, []);

    return token ? (
        userT === '' ? (
            <Loading />
        )
            :
            // allowedRole.includes(userT.role) ? (
            <Outlet />
        // ) : (
        //     <Err403 />
        // )
    )
        : (
            <Navigate state={{ from: location }} replace to='/auth/sign-in' />
        );
}