import { Outlet } from "react-router";
import { useState, useContext, useEffect } from "react";
import { user } from "../context/dataUser";
import Loading from "./loading";
import axios from "axios";
import Cookie from 'cookie-universal';


export default function RefreshPage() {
    const [loading, setLoading] = useState(true);

    const token_user = useContext(user);
    const token = token_user.auth.token;
    console.log(token);

    const cookie = Cookie();

    const getTokenCookie = cookie.get('Bearer');

    useEffect(() => {
        async function refresh() {
            try {
                await axios.post('http://127.0.0.1:8000/api/admin/refresh', null, {
                    headers: {
                        Authorization: 'Bearer ' + getTokenCookie
                    }
                })
                    .then(data => {
                        const admin = data.data.admin;
                        const token = data.data.token.original.access_token;

                        cookie.set('Bearer', token);
                        token_user.setAuth(prev => {
                            return { token: token, dataUser: admin };
                        });
                        console.log('refrsh page ', data);
                    });
            } catch (err) {
                console.log('error refrsh page ', err);
            } finally {
                setLoading(false);
            }
        }
        !token ? refresh() : setLoading(false);
    }, [])


    return loading ? <Loading /> : <Outlet />;
}