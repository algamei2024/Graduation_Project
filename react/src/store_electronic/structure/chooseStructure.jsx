import React, { useContext, useRef, useState } from 'react'
import './structure.css';
import { prevent } from '../step'
import { storeInfo } from '@/context/info_store';
import { Button } from '@material-tailwind/react';
import axios from 'axios';
import Cookie from 'cookie-universal';
import Loading from '@/refreshPage/loading';
import { Link, useNavigate } from 'react-router-dom';


export default function ChooseStructure() {
    const StoreInfo = useContext(storeInfo);
    const cookie = Cookie();
    // const token = cookie.get('trader');
    const [loading, setLoading] = useState(false);

    console.log('name trader', StoreInfo.info.name);
    console.log('email', StoreInfo.info.email);
    console.log('password', StoreInfo.info.password);
    console.log('password confirmation', StoreInfo.info.password_confirmation);
    console.log('name store : ', StoreInfo.info.nameStore);
    console.log('mobile : ', StoreInfo.info.mobile);
    console.log('logo : ', StoreInfo.info.logo);
    console.log('desc : ', StoreInfo.info.description);
    console.log('location_sotre : ', StoreInfo.info.location_sotre);
    console.log('address_store : ', StoreInfo.info.address_store);
    console.log('num_struct : ', StoreInfo.info.num_struct);

    ///
    const [struct, setStruct] = useState('');

    const one = useRef(null);
    const tow = useRef(null);
    const three = useRef(null);
    console.log(struct);
    const selectHandle = (e, select) => {
        setStruct(select);
        StoreInfo.setInfo(prev => {
            return { ...prev, num_struct: select };
        });
        one.current.style.cssText = 'border:none';
        tow.current.style.cssText = 'border:none';
        three.current.style.cssText = 'border:none';
        switch (select) {
            case 'one':
                one.current.style.cssText = 'border:3px solid black';
                break;
            case 'tow':
                tow.current.style.cssText = 'border:3px solid black';
                break;
            case 'three':
                three.current.style.cssText = 'border:3px solid black';
                break;
        }
    }

    let nav = useNavigate();
    const goBack = (e) => {
        e.preventDefault();
        prevent();
        nav('/information/infolocation');
    }

    async function senDataStore() {
        setLoading(true);
        const formData = new FormData();
        formData.append('name', StoreInfo.info.name);
        formData.append('email', StoreInfo.info.email);
        formData.append('password', StoreInfo.info.password);
        formData.append('password_confirmation', StoreInfo.info.password_confirmation);
        formData.append('nameStore', StoreInfo.info.nameStore);
        formData.append('logo', StoreInfo.info.logo);
        formData.append('description', StoreInfo.info.description);
        formData.append('mobile', StoreInfo.info.mobile);
        formData.append('location_sotre', StoreInfo.info.location_sotre);
        formData.append('address_store', StoreInfo.info.address_store);
        formData.append('num_struct', StoreInfo.info.num_struct);

        // if (StoreInfo.info.password === StoreInfo.info.password_confirmation) {
        //     console.log('---------------------yes it;s match--------------------------');
        // }
        try {
            // axios.defaults.withCredentials = true;
            await axios.post('http://127.0.0.1:8000/api/admin/register', formData)
                .then(res => {
                    console.log('تم الارسال بنجاح', res);
                    console.log('تم التسجيل ', res);
                    // const dataUser = res.data.user;
                    // const token = res.data.access_token;
                    // userNow.setAuth({ token, dataUser });
                    // cookie.set('trader', token);
                    setLoading(false);
                    // window.location.pathname = '/dashboard/home';
                    window.location = 'http://127.0.0.1:8000/admin';
                })
                .catch(err => {
                    console.log('خطا في ', err);
                    setLoading(false);
                });
        }
        catch (err) {
            console.log('حدث خطا ', err);
        }
    }



    return (
        <div>
            {loading ? <Loading fullPage={false} /> : ''}
            <div dir="rtl">
                <div>
                    <h2 style={{
                        fontWeight: 'bolder',
                        fontSize: '20px',
                        marginRight: '30px'
                    }}>اختر قالب المتجر</h2>
                    <br />
                    <div className='structure'>
                        {/* <div ref={one} className="card-type" onClick={(e) => selectHandle(e, 'one')}>
                            <div className="card_load" />
                            <div className="card_load_extreme_title" />
                            <div className='grid-one'>
                                <div className="card_load_extreme_descripion-one" />
                                <div className="card_load_extreme_descripion-one" />
                            </div>
                            <div className="card_load_extreme_title" />
                        </div>
                        <div ref={tow} className="card-type" onClick={(e) => selectHandle(e, 'tow')}>
                            <div className="card_load" />
                            <div className="card_load_extreme_title" />
                            <div className="card_load_extreme_descripion" />
                            <div className="card_load_extreme_title" />
                        </div>
                        <div ref={three} className="card-type" onClick={(e) => selectHandle(e, 'three')}>
                            <div className="card_load" />
                            <div className="card_load_extreme_title" />
                            <div className='grid-three'>
                                <div className="card_load_extreme_descripion-one" />
                                <div className="card_load_extreme_descripion-one" />
                                <div className="card_load_extreme_descripion-one" />
                            </div>
                            <div className="card_load_extreme_title" />
                        </div> */}
                        <div style={{ border: '4px solid green' }} className="one_k">
                            <img style={{ maxWidth: '100%' }} src="/assets/img/imgTemplate/1.jpg" alt="jkkk" />
                        </div>
                        <div className="one_k">
                            <img src="/assets/img/imgTemplate/4.jpg" alt="" />
                            <div className="cont">غير متوفر</div>
                        </div>
                        <div className="one_k">
                            <img src="/assets/img/imgTemplate/10.jpg" alt="" />
                            <div className="cont">غير متوفر</div>
                        </div>
                    </div>
                </div>

                <div style={{
                    width: '50%',
                    marginTop: '30px',
                    display: 'flex',
                    flexDirection: 'row-reverse',
                    justifyContent: 'space-around'
                }} className="buttons">
                    <Button className='btn-prev' onClick={goBack}>
                        السابق
                    </Button>
                    {/* <Button onClick={senDataStore} color='#1A2331'> */}
                    <Button onClick={senDataStore}>
                        حفظ
                    </Button>
                </div>

            </div>
        </div>
    )
}
