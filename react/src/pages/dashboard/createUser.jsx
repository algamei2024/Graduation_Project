import {
  Card,
  Input,
  Checkbox,
  Button,
  Typography,
  Select,
  Option
} from "@material-tailwind/react";
import { useEffect, useRef, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import Cookie from 'cookie-universal';

export function CreateUser() {
  const [accept, setAccept] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    role: '',
    password: '',
    password_confirmation: ''
  });

  const cookie = Cookie();
  const token = cookie.get('Bearer');


  const nav = useNavigate();

  //جعل المؤشر يؤشر على حقل الاسم بداية فتح الصفحة
  const myFocus = useRef(null);
  useEffect(() => {
    myFocus.current.focus();
  }, []);

  function handleChange(e) {
    setFormData(prev => {
      return { ...prev, [e.target.name]: e.target.value };
    })
  }

  //ارسال بيانات المستخدم المضاف
  async function submit(e) {
    let flag = true;
    setAccept(true);
    e.preventDefault();
    if (formData.name === '' || formData.password.length < 8 || formData.password_confirmation !== formData.password) {
      flag = false;
    } else flag = true;
    try {
      if (flag) {
        const data = {
          name: formData.name,
          email: formData.email,
          role: formData.role,
          status: 'active',
          password: formData.password,
          password_confirmation: formData.password_confirmation,
        };
        // let res = await (props.type == 'post' ? axios.post : axios.put)(`http://127.0.0.1:8000/api/${props.endPoint}`,
        let res = await axios.post('http://127.0.0.1:8000/api/admin', data, {
          headers: {
            Authorization: 'Bearer ' + token
          }
        });
        console.log('response is ', res);
        if (res.status === 200) {
          console.log('تم إنشاء مستخدم جديد');
          window.location.pathname = '/dashboard/tables';
        }
      }
    } catch (err) {
      console.log(err);
    }
  }





  return (
    <section className="m-8 flex">
      <div className="w-2/5 h-full hidden lg:block">
        <img
          src="/img/pattern.png"
          className="h-full w-full object-cover rounded-3xl"
        />
      </div>
      <div className="w-full lg:w-3/5 flex flex-col items-center justify-center">
        <div className="text-center">
          <Typography variant="h2" className="font-bold mb-4">Create New User</Typography>
          <Typography variant="paragraph" color="blue-gray" className="text-lg font-normal">Enter information New User.</Typography>
        </div>
        <form onSubmit={submit} className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2">
          <div className="mb-1 flex flex-col gap-4">
            {/* Name */}
            <div className="mb-1 flex flex-col gap-3">
              <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                Your Name
              </Typography>
              <Input
                name='name'
                value={formData.name}
                ref={myFocus}
                size="lg"
                placeholder="name"
                onChange={handleChange}
                className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                labelProps={{
                  className: "before:content-none after:content-none",
                }}
              />
              {formData.name.length < 1 && accept && <p className='text-red-500 text-[11px] m-0'>Name is required</p>}
            </div>

            {/* email */}
            <div className="mb-1 flex flex-col gap-3">
              <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                Your email
              </Typography>
              <Input
                name='email'
                type='email'
                required
                value={formData.email}
                size="lg"
                placeholder="name@mail.com"
                onChange={handleChange}
                className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                labelProps={{
                  className: "before:content-none after:content-none",
                }}
              />
            </div>


            {/* password */}
            <div className="mb-1 flex flex-col gap-3">
              <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                Your Password
              </Typography>
              <Input
                type="password"
                name='password'
                value={formData.password}
                size="lg"
                placeholder="password"
                onChange={handleChange}
                className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                labelProps={{
                  className: "before:content-none after:content-none",
                }}
              />
              {formData.password.length < 8 && accept && <p className='text-red-500 text-[11px] m-0'>password must be length 8</p>}
            </div>


            {/* password confirmation */}
            <div className="mb-1 flex flex-col gap-3">
              <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                Paaword Confirmation
              </Typography>
              <Input
                type="password"
                name='password_confirmation'
                value={formData.password_confirmation}
                size="lg"
                placeholder="pass confirm"
                onChange={handleChange}
                className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                labelProps={{
                  className: "before:content-none after:content-none",
                }}
              />
              {(formData.password.length >= 8 && formData.password_confirmation !== formData.password && accept) ? <p className='text-red-500 text-[11px] m-0'>password not equal</p> : ''}
            </div>


            {/* الصلاحية */}
            <div className="mb-1 flex flex-col gap-4">
              <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                الصلاحية
              </Typography>
              <Select
                value={formData.role}
                onChange={(value) =>
                  setFormData((prev) => {
                    return { ...prev, role: value };
                  })
                }
              // label="اختر الصلاحية"
              >
                <Option disabled value="">
                  اختر الصلاحية
                </Option>
                <Option value="owner">مسؤول</Option>
              </Select>
            </div>

          </div>

          <Checkbox
            label={
              <Typography
                variant="small"
                color="gray"
                className="flex items-center justify-start font-medium"
              >
                I agree the&nbsp;
                <a
                  href="#"
                  className="font-normal text-black transition-colors hover:text-gray-900 underline"
                >
                  Terms and Conditions
                </a>
              </Typography>
            }
            containerProps={{ className: "-ml-2.5" }}
          />
          <Button type='submit' color='#1A2331' className="mt-6" fullWidth>
            Create
          </Button>

        </form>

      </div>
    </section>
  );
}

export default CreateUser;