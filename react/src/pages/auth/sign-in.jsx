import { user } from "@/context/dataUser";
import {
  Card,
  Input,
  Checkbox,
  Button,
  Typography,
} from "@material-tailwind/react";
import { useContext, useEffect, useRef, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import Cookie from 'cookie-universal';
import axios from "axios";
import Loading from "@/refreshPage/loading";


export function SignIn() {
  const [accept, setAccept] = useState(false);
  const [errLogin, setErrLogin] = useState('');
  const [loading, setLoading] = useState(false);
  const [formData, setFormData] = useState({
    email: '',
    password: '',
  });

  const nav = useNavigate();

  const userNow = useContext(user);
  // console.log('the auth', userNow.auth);
  const cookie = Cookie();

  //جعل المؤشر يؤشر على حقل البريد بداية فتح الصفحة
  const myFocus = useRef(null);
  useEffect(() => {
    myFocus.current.focus();
  }, []);


  function handleChange(e) {
    setFormData(prev => {
      return { ...prev, [e.target.name]: e.target.value };
    })
  }

  async function submit(e) {
    let flag = true;
    setAccept(true);
    e.preventDefault();
    if (formData.password.length < 8) {
      flag = false;
    } else flag = true;

    try {
      if (flag) {
        setLoading(true);
        const data = {
          email: formData.email,
          password: formData.password,
          remember: true
        }
        const res = await axios.post('http://127.0.0.1:8000/api/admin/login', data)
          .catch(err => {
            setLoading(false);
            console.log('error from login ', err);
            // console.log(err.response.data.error);
            setErrLogin(err.response.data.error);
          });
        // await new Promise(resolve=>setTimeout(resolve,3000));
        // console.log(res);
        if (res) {
          if (res.status === 200) {

            const dataUser = res.data.admin;
            const token = res.data.token.original.access_token;

            console.log(res);


            //هنا حماية الدخول مرة اخرى لانه لا يتم المساح بالدخول للداشبورد الا للمسؤولين
            if (dataUser.role === 'admin') {
              cookie.set('trader', token);
              console.log('----------تم وجاهز للانتقال الى مشروغ لارافل------------');
              setLoading(false);
              window.location = 'http://127.0.0.1:8000/admin';
            } else {
              cookie.set('Bearer', token);
              userNow.setAuth({ token, dataUser });
              setLoading(false);
              window.location.pathname = '/dashboard/home';

            }


            //login in laravel project 
            // const res2Login = await axios.post('http://127.0.0.1:8000/user/login', res, {
            //   headers: {
            //     Authorization: 'Bearer ' + token
            //   }
            // })
            //   .catch(err => {
            //     console.log('error from login laravel ', err);
            //   });
            // if (res2Login) {
            //   if (res2Login.status === 200) {
            //     console.log('true login to laravel', res2Login);
            //   }
            // }
            ///////////end login in laravel project

            // const role = res.data.data.user.role;
            // const go = role === 'admin' ? 'users' : 'writer';
            // nav(`/dashboard/${go}`);

            // nav('/information');

          }
          else if (res.status === 403) {
            console.log('footer');
            // nav('/error');
          }
        }
      }
    } catch (err) {
      console.log('try catch erorr ', err.message);
      // if (err.response.status === 422) {
      //     console.log('footer');
      //     nav('/go/footer');
      // }
    }

    console.log('the auth', userNow);

  }


  return (
    <div>
      {loading ? <Loading fullPage={false} /> : ''}
      <section className="m-8 flex gap-4">
        <div className="w-full lg:w-3/5 mt-24">
          <div className="text-center">
            <Typography variant="h2" className="font-bold mb-4">تسجيل الدخول</Typography>
            <Typography variant="paragraph" color="blue-gray" className="text-lg font-normal">ادخل بريدك الالكتروني لتسجيل الدخول</Typography>
          </div>
          <form onSubmit={submit} className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2">
            <div style={{ textAlign: 'right' }} className="mb-1 flex flex-col gap-6">
              <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                بريدك الالكتروني
              </Typography>
              <Input
                style={{ textAlign: 'right' }}
                name='email'
                value={formData.email}
                ref={myFocus}
                size="lg"
                placeholder="name@mail.com"
                onChange={handleChange}
                className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                labelProps={{
                  className: "before:content-none after:content-none",
                }}
              />
              {/* إظهار رسالة الخطا */}
              {!errLogin ? "" : <p style={{ color: 'red', fontSize: '11px' }}>{errLogin}</p>}
              <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                كلمة السر
              </Typography>
              <Input
                style={{ textAlign: 'right' }}
                name="password"
                type="password"
                value={formData.password}
                size="lg"
                placeholder="********"
                onChange={handleChange}
                className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                labelProps={{
                  className: "before:content-none after:content-none",
                }}
              />
              {formData.password.length < 8 && accept && <p className='text-red-500 text-[11px] m-0'>password must be length 8</p>}
            </div>

            {/* الشروط والاحكام */}
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

            <Button type='submit' className="mt-6" fullWidth>
              تسجيل الدخول
            </Button>

            {/* نسيت كلمة السر */}
            {/* <div className="flex items-center justify-between gap-2 mt-6">
              <Checkbox
                label={
                  <Typography
                    variant="small"
                    color="gray"
                    className="flex items-center justify-start font-medium"
                  >
                    Subscribe me to newsletter
                  </Typography>
                }
                containerProps={{ className: "-ml-2.5" }}
              />

              <Typography variant="small" className="font-medium text-gray-900">
                <a href="#">
                  نسيت كلمة السر
                </a>
              </Typography>
            </div> */}

            {/* تسجيل الدخول باستخدام كلمة جوجل */}
            {/* <div className="space-y-4 mt-8">
            <Button size="lg" color="white" className="flex items-center gap-2 justify-center shadow-md" fullWidth>
              <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clipPath="url(#clip0_1156_824)">
                  <path d="M16.3442 8.18429C16.3442 7.64047 16.3001 7.09371 16.206 6.55872H8.66016V9.63937H12.9813C12.802 10.6329 12.2258 11.5119 11.3822 12.0704V14.0693H13.9602C15.4741 12.6759 16.3442 10.6182 16.3442 8.18429Z" fill="#4285F4" />
                  <path d="M8.65974 16.0006C10.8174 16.0006 12.637 15.2922 13.9627 14.0693L11.3847 12.0704C10.6675 12.5584 9.7415 12.8347 8.66268 12.8347C6.5756 12.8347 4.80598 11.4266 4.17104 9.53357H1.51074V11.5942C2.86882 14.2956 5.63494 16.0006 8.65974 16.0006Z" fill="#34A853" />
                  <path d="M4.16852 9.53356C3.83341 8.53999 3.83341 7.46411 4.16852 6.47054V4.40991H1.51116C0.376489 6.67043 0.376489 9.33367 1.51116 11.5942L4.16852 9.53356Z" fill="#FBBC04" />
                  <path d="M8.65974 3.16644C9.80029 3.1488 10.9026 3.57798 11.7286 4.36578L14.0127 2.08174C12.5664 0.72367 10.6469 -0.0229773 8.65974 0.000539111C5.63494 0.000539111 2.86882 1.70548 1.51074 4.40987L4.1681 6.4705C4.8001 4.57449 6.57266 3.16644 8.65974 3.16644Z" fill="#EA4335" />
                </g>
                <defs>
                  <clipPath id="clip0_1156_824">
                    <rect width="16" height="16" fill="white" transform="translate(0.5)" />
                  </clipPath>
                </defs>
              </svg>
              <span>Sign in With Google</span>
            </Button>
            <Button size="lg" color="white" className="flex items-center gap-2 justify-center shadow-md" fullWidth>
              <img src="/img/twitter-logo.svg" height={24} width={24} alt="" />
              <span>Sign in With Twitter</span>
            </Button>
          </div> */}

            <Typography variant="paragraph" className="text-center text-blue-gray-500 font-medium mt-4">
              لا يوجد لدي حساب ؟
              <Link to="/auth/sign-up" className="text-gray-900 ml-1">إنشاء حساب</Link>
            </Typography>
          </form>

        </div>
        <div className="w-2/5 h-full hidden lg:block">
          <img
            src="/img/pattern.png"
            className="h-full w-full object-cover rounded-3xl"
          />
        </div>

      </section>
    </div>
  );
}

export default SignIn;
