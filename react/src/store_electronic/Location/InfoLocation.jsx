import { storeInfo } from '@/context/info_store';
import React, { useContext, useEffect, useState } from 'react'
import { Link, useNavigate } from 'react-router-dom';
import { Button } from '@material-tailwind/react';
import { next, prevent } from '../step';
import axios from 'axios';
import Loading from '@/refreshPage/loading';

export default function InfoLocation() {
    const [StoreAddress, setStoreAddress] = useState('');
    const [name, setName] = useState('');
    const [neighborhood, setNeighborhood] = useState('');
    const [street, setStreet] = useState('');
    const [loading, setLoading] = useState(false);


    /////



    const StoreInfo = useContext(storeInfo);
    //اجزاء الموقع
    const [location, setLocation] = useState({
        city: '',
        directorate: '',//المديرية
        street: '',
    });


    console.log('name trader', StoreInfo.info.name);
    console.log('email', StoreInfo.info.email);
    console.log('password', StoreInfo.info.password);
    console.log('password confirmation', StoreInfo.info.password_confirmation);
    console.log('name store', StoreInfo.info.nameStore);
    console.log('name mobile', StoreInfo.info.mobile);
    console.log('name logo', StoreInfo.info.logo);
    console.log('name desc', StoreInfo.info.description);

    //بيانات المتجر
    function handleInput(e) {
        StoreInfo.info((prev) => {
            return { ...prev, [e.target.name]: e.target.value };
        });
    }




    //حفظ بيانات الموقع
    useEffect(() => {
        //يتم تخزين بيانات الموقع في useContext كلما تغيرت قيمة loaction
        //هذا location فيه ثلاث قيم قيمة المدينة والحي والشارع
        const dd = { ...StoreInfo.info };
        dd.location_sotre = `${location.city}/${location.directorate}-${location.street}`;

        StoreInfo.setInfo(dd);
    }, [location]);


    function handleLocation(e) {
        setLocation(prev => {
            return { ...prev, [e.target.name]: e.target.value };
        });
    }




    ////
    //دالة التالي 
    let nav = useNavigate();
    const handleClick = (e) => {
        e.preventDefault();
        next();
        nav('/information/structure',);
    }

    // دالة السابق
    const goBack = (e) => {
        e.preventDefault();
        prevent();
        nav('/information');
    }

    // دالة ارسال البيانات
    // async function senDataStore() {
    //     setLoading(true);
    //     const formData = new FormData();
    //     formData.append('name', StoreInfo.info.name);
    //     formData.append('email', StoreInfo.info.email);
    //     formData.append('password', StoreInfo.info.password);
    //     formData.append('password_confirmation', StoreInfo.info.password_confirmation);
    //     formData.append('nameStore', StoreInfo.info.nameStore);
    //     formData.append('logo', StoreInfo.info.logo);
    //     formData.append('description', StoreInfo.info.description);
    //     formData.append('mobile', StoreInfo.info.mobile);
    //     formData.append('location_sotre', StoreInfo.info.location_sotre);
    //     formData.append('address_store', StoreInfo.info.address_store);

    //     try {
    //         // axios.defaults.withCredentials = true;
    //         await axios.post('http://127.0.0.1:8000/api/admin/register', formData)
    //             .then(res => {
    //                 console.log('تم الارسال بنجاح', res);
    //                 console.log('تم التسجيل ', res);
    //                 // const dataUser = res.data.user;
    //                 // const token = res.data.access_token;
    //                 // userNow.setAuth({ token, dataUser });
    //                 // cookie.set('trader', token);
    //                 setLoading(false);
    //                 // window.location.pathname = '/dashboard/home';
    //                 window.location = 'http://127.0.0.1:8000/admin';
    //             })
    //             .catch(err => {
    //                 console.log('خطا في ', err);
    //                 setLoading(false);
    //             });
    //     }
    //     catch (err) {
    //         console.log('حدث خطا ', err);
    //     }
    // }

    return (
        <div>
            {/* {loading ? <Loading fullPage={false} /> : ''} */}
            <div className='form-info'>
                <div className="formbold-main-wrapper">
                    <div className="formbold-form-wrapper">
                        <div className="formbold-mb-5">
                            <label
                                className="formbold-form-label"
                                htmlFor="location"
                            >
                                حدد موقع المتجر
                            </label>
                            <iframe
                                value={StoreInfo.info.address_store}
                                onChange={handleInput}
                                id='location'
                                name='address_store'
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30214.79221612597!2d44.010123!3d15.552251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1635b7b8b8b8b8b8%3A0x8b8b8b8b8b8b8b8!2z2KfZhiDYp9mE2qTZiNin2YTYp9mE2YXZhtmH2rjYtNmE!5e0!3m2!1sen!2sus!4v1631892745716!5m2!1sen!2sus"
                                width="370"
                                height="250"
                                style={{ border: '0;' }}
                                allowfullscreen=""
                                loading="lazy">
                            </iframe>
                        </div>
                        <div className="formbold-mb-5">
                            <label
                                className="formbold-form-label"
                                htmlFor="StoreAddress"
                            >
                                عنوان المتجر
                            </label>
                            <input
                                className="formbold-form-input"
                                id="StoreAddress"
                                name="city"
                                value={location.city}
                                placeholder="ادخل العنوان"
                                type="text"
                                onChange={handleLocation}
                            />
                        </div>
                        <div className="formbold-mb-5">
                            <label
                                className="formbold-form-label"
                                htmlFor="street"
                            >
                                الشارع
                            </label>
                            <input
                                className="formbold-form-input"
                                value={location.street}
                                id="street"
                                name="street"
                                placeholder="ادخل الشارع الاقرب لمتجرك"
                                type="text"
                                onChange={handleLocation}
                            />
                        </div>
                        <div className="formbold-mb-5">
                            <label
                                className="formbold-form-label"
                                htmlFor="neighborhood"
                            >
                                الحي
                            </label>
                            <input
                                className="formbold-form-input"
                                value={neighborhood}
                                id="neighborhood"
                                name="directorate"
                                value={location.directorate}
                                placeholder="ادخل الحي الذي يتواجد فيه متجرك"
                                type="text"
                                onChange={handleLocation}
                            />
                        </div>

                        <div style={{
                            display: 'flex',
                            flexDirection: 'row-reverse',
                            justifyContent: 'space-around'
                        }} className="buttons">
                            <Button className='btn-prev' onClick={goBack}>
                                السابق
                            </Button>
                            <Button className='btn-next' onClick={handleClick} >التالي</Button>

                        </div>
                        {/* <Button onClick={senDataStore} color='#1A2331' className="mt-6">
                            save
                        </Button> */}
                    </div>
                </div>
            </div>
        </div>
    )
}
