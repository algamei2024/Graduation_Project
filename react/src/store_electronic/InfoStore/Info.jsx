import React, { useContext, useRef, useState } from 'react'
import uploadFile from './fileUpload.png';
import './info.css';
import { Link, useNavigate } from 'react-router-dom';
import { next, prevent } from '../step';
import { storeInfo } from '@/context/info_store';
import axios from 'axios';
import Loading from '@/refreshPage/loading';
import { Button } from '@material-tailwind/react';

export default function Info() {
    ////
    const StoreInfo = useContext(storeInfo);
    const [nameStoreErr, setNameStoreErr] = useState('');
    const [mobileErr, setMobileErr] = useState('');
    const [imgErr, setImgErr] = useState('');
    const [accept, setAccept] = useState(false);
    const [loading, setLoading] = useState(false);

    //اكواد السحب والافلات 
    const [src, setSrc] = useState(uploadFile);
    const fileImageRef = useRef(null);

    ///
    let nav = useNavigate();
    const handleClick = async (e) => {
        e.preventDefault();
        setAccept(true);
        if (StoreInfo.info.nameStore?.length > 2 && StoreInfo.info.mobile?.length > 6 && StoreInfo.info.logo) {
            setLoading(true);
            // التحقق من رقم المتجر مما اذا كان موجود سابقا
            const data = {
                nameStore: StoreInfo.info.nameStore,
                mobile: StoreInfo.info.mobile,
            }
            next();
            await axios.post('http://127.0.0.1:8000/api/admin/testNameAndMobileStore', data)
                .then(res => {
                    setLoading(false);
                    nav('/information/InfoLocation');
                })
                .catch(err => {
                    console.log('error from mobile found => ', err);
                    // فحص رسالة الخطا ما اذا كانت بسبب الاسم او الرقم
                    if (err.response.data.error) {
                        setNameStoreErr(err.response.data.error);
                        setMobileErr(''); // نقوم بمسح رسالة الخطا السابقة من رسالة خطا الرقم 
                    } else {
                        setMobileErr('رقم المتجر موجود سابقا');
                        setNameStoreErr(''); // نقوم بمسح رسالة الخطا السابقة من رسالة خطا الاسم 
                    }
                    setLoading(false);
                });
        } else {
            console.log('لا يمكن الانتقال بسبب وجود خطا في ادخال البيانات');
        }
    }

    //سحب وافلات الشعار
    const handleDrop = (e) => {
        e.preventDefault();
        e.stopPropagation();
        const file = e.dataTransfer.files;

        if (file[0].type.includes('image')) {
            fileImageRef.current.files = file;
            const imageUrl = URL.createObjectURL(file[0]);
            setSrc(imageUrl);
        }
    }
    const handleDragOver = (e) => {
        e.preventDefault();
        e.stopPropagation();
    }

    //تخزين القيم
    function handleChange(e) {
        StoreInfo.setInfo(prev => {
            return { ...prev, [e.target.name]: e.target.value };
        });
    }
    // اختيار الصورة
    function selectLogo(e) {
        const image = e.target.files[0];
        console.log(image);
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (image) {
            if (allowedTypes.includes(image.type)) {
                setImgErr(ee => ee = ''); //تفريغ رسالة خطا الصورة
                document.querySelector('.uploadFile').src = window.URL.createObjectURL(image);
                StoreInfo.setInfo(prev => {
                    return { ...prev, logo: e.target.files[0] };
                });
            } else {
                setImgErr('انواع الصورة المسموح بها : jpeg,png,gif');
                document.querySelector('.uploadFile').src = uploadFile; //ارجاع الصورة الافتراضية
            }
        } else {
            setImgErr(ee => ee = ''); //تفريغ رسالة خطا الصورة
            console.log('لم يتم اختيار ملف');
            document.querySelector('.uploadFile').src = uploadFile; //ارجاع الصورة الافتراضية
        }

    }

    // دالة السابق
    const goBack = (e) => {
        e.preventDefault();
        prevent();
        nav('/auth/sign-up');
    }


    return (
        <div>
            {loading ? <Loading fullPage={false} /> : ''}
            <div className='form-info'>
                <div className="formbold-main-wrapper">
                    <div className="formbold-form-wrapper">

                        {/* name store */}
                        <div className="formbold-mb-5">
                            <label
                                className="formbold-form-label"
                                htmlFor="nameStore"
                            >
                                اسم المتجر
                            </label>
                            <input
                                className="formbold-form-input"
                                id="nameStore"
                                name="nameStore"
                                value={StoreInfo.info.nameStore}
                                placeholder="اكتب اسم متجرك"
                                type="text"
                                onChange={handleChange}
                            />
                            {/* اظهار رسالة الخطا ما اذا كان اسم المتجر موجود */}
                            {nameStoreErr && <p className='text-red-500 text-[11px] m-0'>{nameStoreErr}</p>}
                            {/* اظهار رسالة الخطا  */}
                            {!StoreInfo.info.nameStore && accept ?
                                <p className='text-red-500 text-[11px] m-0'>اسم المتجر مطلوب</p>
                                : StoreInfo.info.nameStore?.length < 2 && accept ? <p className='text-red-500 text-[11px] m-0'>يجب ان يكون اسم المتجر اكثر من حرفين </p>
                                    : ''
                            }
                            {/* {StoreInfo.info.nameStore?.length < 2 && accept && <p className='text-red-500 text-[11px] m-0'>يجب ان يكون اسم المتجر اكثر من حرفين </p>} */}
                        </div>

                        {/* mobile store */}
                        <div className="formbold-mb-5">
                            <label
                                className="formbold-form-label"
                                htmlFor="email"
                            >
                                رقم المتجر
                            </label>
                            <input
                                className="formbold-form-input"
                                id="mobile"
                                name="mobile"
                                value={StoreInfo.info.mobile}
                                placeholder="ادخل رقم متجرك"
                                type="text"
                                onChange={handleChange}
                            />
                            {/* اظهار رسالة الخطا ما اذا رقم المتجر موجود */}
                            {mobileErr && <p className='text-red-500 text-[11px] m-0'>{mobileErr}</p>}
                            {/* اظهار رسالة الخطا في حالة ادخال رقم المتجر بطريقة غير صحيحة */}
                            {!StoreInfo.info.mobile && accept ?
                                <p className='text-red-500 text-[11px] m-0'>رقم المتجر مطلوب</p>
                                : StoreInfo.info.mobile?.length < 6 && accept ? <p className='text-red-500 text-[11px] m-0'>يجب ان يكون رقم المتجر اكثر من 6 احرف </p>
                                    : ''
                            }
                        </div>

                        {/* logo */}
                        <div className="mb-6 pt-4">
                            <label className="formbold-form-label formbold-form-label-2">
                                شعار المتجر
                            </label>
                            <div
                                className="formbold-mb-5 formbold-file-input"
                                onDragOver={handleDragOver}
                                onDrop={handleDrop}
                            >
                                <div className='form'>
                                    <label
                                        className="drop-container"
                                        htmlFor="file-input"
                                    >
                                        <span className="drop-title">
                                            اسحب الشعار وافلته هنا
                                        </span>
                                        <img className='uploadFile' src={src} alt="upload file" />
                                        <input
                                            draggable='true'
                                            ref={fileImageRef}
                                            accept="image/*"
                                            id="file-input"
                                            required
                                            type="file"
                                            name="logo"
                                            value={StoreInfo.setInfo.logo}
                                            onChange={selectLogo}
                                        />
                                    </label>
                                </div>
                                {/* اظهار رسالة الخطا  */}
                                {imgErr && <p className='text-red-500 text-[11px] m-0'>{imgErr}</p>}
                            </div>
                        </div>
                        <div className="formbold-mb-5">
                            <label
                                className="formbold-form-label"
                                htmlFor="email"
                            >
                                اختر وصف لمتجرك
                            </label>
                            <textarea
                                rows={5}
                                className="formbold-form-input"
                                id="desc"
                                name="description"
                                value={StoreInfo.info.description}
                                placeholder="مثال: متجر بن متجر متخصص في بيع الالعاب الالكترونيه"
                                type="text"
                                onChange={handleChange}
                            />
                        </div>
                        <div style={{
                            display: 'flex',
                            flexDirection: 'row-reverse',
                            justifyContent: 'space-around'
                        }} className="buttons">
                            {/* <Link className="btn btn-prev"
                                onClick={prevent()}
                                to='/auth/sign-up' >
                                السابق
                            </Link> */}

                            <Button className='btn-prev' onClick={goBack}>
                                السابق
                            </Button>
                            <Button className='btn-next' onClick={handleClick} >التالي</Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}