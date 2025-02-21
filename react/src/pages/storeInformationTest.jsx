import { Link } from 'react-router-dom'
import { useEffect, useState } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router';
import { Button } from '@material-tailwind/react';
import Cookie from 'cookie-universal';

export default function StoreInformationTest() {
    const [testRun, setTestRun] =useState(0);
    const [formStore, setFormStore] = useState({
        name:'',
        logo:'',
        description:'',
        mobile:'',
        location_sotre:'',
    });
    const [location, setLocation] = useState({
        city:'',
        directorate:'',//المديرية
        street:'',
    });


    const cookie = Cookie();
    const token = cookie.get('Bearer');

    const nav = useNavigate();

    //بيانات المتجر
    function handleInput(e){
        setFormStore((prev)=>{
            return {...prev, [e.target.name]:e.target.value};
        });
    }

    //بيانات الموقع
    useEffect(()=>{
        const dd = {...formStore};
        dd.location_sotre= `${location.city}/${location.directorate}-${location.street}`;
        
        setFormStore(dd);
    },[location]);
    
    function handleLocation(e){
        setLocation(prev=>{
            return {...prev,[e.target.name]:e.target.value};
        });
    }
    
    

    //اختيار الصورة
    function handleSelectedImage(even) {
        setFormStore((prev)=>{
            return {...prev, logo:even.target.files[0]};
        });
    }
    async function sendInfromation(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('name',formStore.name);
        formData.append('logo',formStore.logo);
        formData.append('description',formStore.description);
        formData.append('mobile',formStore.mobile);
        formData.append('location_sotre',formStore.location_sotre);
        try {
            await axios.post('http://127.0.0.1:8000/api/store/information', formData,{
                headers:{
                    Authorization:'Bearer '+ token
                }
            })
                        .then(res=>{
                            console.log('تم الارسال بنجاح', res);
                            window.location.pathname = '/dashboard/home';
                        })
                        .catch(err => console.log('خطا في ', err));
        }
        catch (err) {
            console.log('حدث خطا ', err);
        }
    }
    return (
        <div dir='rtl'>
            <form onSubmit={sendInfromation} encType='multipart/form-data'>
                {/* name */}
                <label>ادخل اسم المتجر</label>
                <input type='text' name='name' value={formStore.name} onChange={handleInput} style={{ width: '200px' }} />
                <br />

                {/* mobile */}
                <label>ادخل هاتف المتجر</label>
                <input type='number' name='mobile' value={formStore.mobile} onChange={handleInput} style={{ width: '200px' }} />
                <br />


                {/* logo */}
                <label>ادخل شعار المتجر</label>
                <input type='file' name='logo' onChange={handleSelectedImage} style={{ width: '200px' }} />
                {formStore.logo && (<img src={URL.createObjectURL(formStore.logo)} alt='uploading' style={{ maxWidth: '100px' }} />)}
                <br />

                {/* location */}
                <label> موقع المتجر</label>
                <div>
                    <div>
                        <label> اسم المدينة</label>
                        <input type='text' name='city' value={location.city} onChange={handleLocation} style={{ width: '200px' }} />
                    </div>
                    <div>
                        <label> الحي/المديرية</label>
                        <input type='text' name='directorate' value={location.directorate} onChange={handleLocation} style={{ width: '200px' }} />
                    </div>
                    <div>
                        <label>  الشارع</label>
                        <input type='text' name='street' value={location.street} onChange={handleLocation} style={{ width: '200px' }} />
                    </div>
                </div>
                <br />


                {/* descriotion */}
                <textarea
                    name='description'
                    value={formStore.description}
                    onChange={handleInput}
                >
                </textarea>

                <br/>

                <Button  color='#1A2331' type='submit' className="mt-6">
                    save
              </Button>
            </form>

        </div>
    )
}
