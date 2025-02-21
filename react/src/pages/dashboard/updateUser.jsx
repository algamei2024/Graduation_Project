import axios from "axios";
import { useState, useEffect, useRef } from "react";
import Cookie from 'cookie-universal';
import { useNavigate } from "react-router";
import { useParams, Link } from "react-router-dom";
import Loading from "@/refreshPage/loading";
import { Typography, Input, Checkbox, Button } from "@material-tailwind/react";
import { BackwardIcon, PlusIcon } from "@heroicons/react/24/solid";

export function UpdateUser() {

  const [accept, setAccept] = useState(false);
  const [disable, setDisable] = useState(true);
  const [loading, setLoading] = useState(false);

  const [userData, setUserData] = useState({
    name: '',
    email: '',
    role: '',
  });

  const cookie = new Cookie();
  const token = cookie.get('Bearer');

  const nav = useNavigate();

  //للتركيز على عنصر ادخال الاسم عند فتح الصفحة
  const myFocus = useRef(null);


  //استخراج id  للمستخدم المطلوب
  // let id = window.location.pathname.split('/').slice(-1)[0];
  let { id } = useParams();

  //receive data for update
  useEffect(() => {
    myFocus.current.focus();
    const fetchUserData = async () => {
      setLoading(true);
      await axios.get(`http://127.0.0.1:8000/api/admin/${id}/edit`, {
        headers: {
          Authorization: 'Bearer ' + token
        }
      }).then((data) => {
        console.log('user data edit ', data.data.admin);
        setUserData(prev => {
          return {
            ...prev,
            name: data.data.admin.name,
            email: data.data.admin.email,
            role: data.data.admin.role
          };
        });
        setLoading(false);
        setDisable(false);

      }).catch(err => {
        nav('/notFound', { replace: true });
        console.log('err from update');
      });//صفحة ليست موجودة ليذهب بنا الى صفحة 404
    };

    fetchUserData();

  }, [])

  function handleChange(e) {
    setUserData(prev => {
      return { ...prev, [e.target.name]: e.target.value };
    })
  }


  //send data updated
  async function submit(e) {
    let flag = true;
    setAccept(true);
    e.preventDefault();
    if (userData.name === '') {
      flag = false;
    } else flag = true;
    try {
      if (flag) {
        const data = {
          name: userData.name,
          email: userData.email,
          // password: userData.password,
          // password_confirmation: userData.password_confirmation,
          role: userData.role,
          status: 'active'
        };

        let res = await axios.put(`http://127.0.0.1:8000/api/admin/${id}`, data, {
          headers: {
            Authorization: 'Bearer ' + token
          }
        }).catch(err => console.log('error from update ', err));
        if (res.status === 200) {
          nav('/dashboard/tables');
        }
      }
    } catch (err) {
      console.log(err.response.status);
    }
  }

  function back() {
    nav('/dashboard/tables');
  }


  return (

    loading ? <Loading fullPage={false} /> : (
      <div>
        <Button
          onClick={back}
          color="#1A2331"
          className="flex items-center h-12 px-6" // تعيين margin أعلى إلى صفر
        >
          <BackwardIcon className="h-3 w-3 mr-2" />
          رجوع
        </Button>
        <section className="m-8 flex">
          <div className="w-2/5 h-full hidden lg:block">
            <img
              src="/img/pattern.png"
              className="h-full w-full object-cover rounded-3xl"
            />
          </div>
          <div className="w-full lg:w-3/5 flex flex-col items-center justify-center">
            <div className="text-center">
              <Typography variant="h2" className="font-bold mb-4">الملف الشخصي</Typography>
              <Typography variant="paragraph" color="blue-gray" className="text-lg font-normal">قم بتعديل الملف الشخصي حسب رغبتك</Typography>
            </div>
            <form onSubmit={submit} className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2">
              <div className="mb-1 flex flex-col gap-4">
                {/* Name */}
                <div className="mb-1 flex flex-col gap-3">
                  <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                    الاسم
                  </Typography>
                  <Input
                    name='name'
                    value={userData.name}
                    ref={myFocus}
                    size="lg"
                    placeholder="name"
                    onChange={handleChange}
                    className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                    labelProps={{
                      className: "before:content-none after:content-none",
                    }}
                  />
                  {userData.name.length < 1 && accept && <p className='error'>Name is required</p>}
                </div>

                {/* email */}
                <div className="mb-1 flex flex-col gap-3">
                  <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                    البريد الالكتروني
                  </Typography>
                  <Input
                    name='email'
                    type='email'
                    required
                    value={userData.email}
                    size="lg"
                    placeholder="name@mail.com"
                    onChange={handleChange}
                    className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                    labelProps={{
                      className: "before:content-none after:content-none",
                    }}
                  />
                </div>


                {/* الصلاحية */}

                {userData.role === 'owner' ? (
                  <div className="mb-1 flex flex-col gap-3">
                    <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                      الصلاحية
                    </Typography>
                    <select value={userData.role} onChange={(e) => setUserData(prev => {
                      return { ...prev, role: e.target.value };
                    })} >
                      <option disabled value=''>اختر الصلاحية</option>
                      <option value='owner'>مسؤول</option>
                      <option value='admin'>تاجر</option>
                    </select>
                  </div>
                )
                  : ""}

              </div>

              {/* <Checkbox
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
              /> */}
              <Button disabled={disable} color='#1A2331' type='submit' className="mt-6" fullWidth>
                Updated Now
              </Button>
            </form>

          </div>
        </section>
      </div>
    )
  );
}

export default UpdateUser;