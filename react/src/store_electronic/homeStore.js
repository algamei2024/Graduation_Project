import React from 'react'
import { Link } from 'react-router-dom'
import ChooseStructure from './structure/chooseStructure'
import { useState } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router';

export default function HomeStore() {
    const [selectedImage, setSelectedImage] = useState(null);
    const [name, setName] = useState(null);

    const nav = useNavigate();

    function handleSelectedImage(even) {
        setSelectedImage(even.target.files[0]);
    }
    async function sendInfromation(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('image', selectedImage);
        formData.append('name_store', name);
        try {
            const res = await axios.post('http://127.0.0.1:8000/api/store/information', formData)
                .catch(err => console.log('خطا في ', err));
            if (res.status === 200) {
                console.log('تم الارسال بنجاح', res);
            } else {
                console.log('خطا في الاستقبال');
            }

            // await fetch('http://127.0.0.1:8000/api/store/information', {
            //     method: 'POST',
            //     body: formData
            // }).then(response => response.json())
            //     .then(res => console.log(res))
            //     .catch(err => console.log('خطا في الاستقبال', err));
        }
        catch (err) {
            console.log('حدث خطا ', err);
        }
        nav('/go/chooseStruct');
    }
    return (
        <div dir='rtl'>
            <form onSubmit={sendInfromation} encType='multipart/form-data'>
                <label>ادخل اسم المتجر</label>
                <input type='text' value={name} onChange={(e) => {
                    setName(e.target.value);
                }} style={{ width: '200px' }} />
                <br />
                <label>ادخل شعار المتجر</label>
                <input type='file' onChange={handleSelectedImage} style={{ width: '200px' }} />
                {selectedImage && (<img src={URL.createObjectURL(selectedImage)} alt='uploading' style={{ maxWidth: '100px' }} />)}
                <br />
                <input type='submit' value='حفظ' />
            </form>
            <br />
            <Link to='go/chooseStruct' >
                انتقال
            </Link>
            <br />
            <Link to='go/footer' >
                Footer
            </Link>

            <Link to='go/header' style={{ margin: '10px' }} >
                header
            </Link>
            <br />
            <Link to='go/register' style={{ margin: '10px' }} >
                Register
            </Link>
            <Link to='go/login' style={{ margin: '10px' }} >
                Login
            </Link>
            <Link to='/dashBoard' >
                Dashboard
            </Link>

        </div>
    )
}
