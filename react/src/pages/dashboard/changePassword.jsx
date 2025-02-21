import axios from "axios";
import { useState, useEffect, useRef } from "react";
import Cookie from 'cookie-universal';
import { useNavigate } from "react-router";
// import { useParams, Link } from "react-router-dom";
// import Loading from "@/refreshPage/loading";
import { Typography, Input, Checkbox, Button } from "@material-tailwind/react";
import { BackwardIcon, PlusIcon } from "@heroicons/react/24/solid";

export function ChangePassword() {

    const [accept, setAccept] = useState(false);
    const [disable, setDisable] = useState(true);

    const [newPassword, setNewPassword] = useState({
        current_password: '',
        new_password: '',
        new_confirm_password: '',
    });

    const cookie = new Cookie();
    const token = cookie.get('Bearer');

    const nav = useNavigate();

    //للتركيز على عنصر ادخال الاسم عند فتح الصفحة
    const myFocus = useRef(null);


    //استخراج id  للمستخدم المطلوب
    // let id = window.location.pathname.split('/').slice(-1)[0];
    // let { id } = useParams();

    //receive data for update
    // useEffect(() => {
    //     myFocus.current.focus();
    //     const fetchUserData = async () => {
    //         setLoading(true);
    //         await axios.post(`http://127.0.0.1:8000/api/admin/changePassword`, {
    //             headers: {
    //                 Authorization: 'Bearer ' + token
    //             }
    //         }).then((data) => {
    //             console.log('user data edit ', data.data.admin);
    //             setLoading(false);
    //             setDisable(false);

    //         }).catch(err => {
    //             nav('/notFound', { replace: true });
    //             console.log('err from update');
    //         });//صفحة ليست موجودة ليذهب بنا الى صفحة 404
    //     };

    //     fetchUserData();

    // }, [])

    function handleChange(e) {
        setNewPassword(prev => {
            return { ...prev, [e.target.name]: e.target.value };
        })
    }


    //send data updated
    async function submit(e) {
        let flag = true;
        setAccept(true);
        e.preventDefault();
        if (newPassword.current_password === '') {
            flag = false;
        } else flag = true;
        try {
            if (flag) {
                let res = await axios.post(`http://127.0.0.1:8000/api/admin/changePassword`, newPassword, {
                    headers: {
                        Authorization: 'Bearer ' + token
                    }
                }).catch(err => console.log('error from change password ', err));
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
        <div>
            <Button
                onClick={back}
                color="#1A2331"
                className="flex items-center h-12 px-6" // تعيين margin أعلى إلى صفر
            >
                <BackwardIcon className="h-3 w-3 mr-2" />
                Back
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
                        <Typography variant="h2" className="font-bold mb-4">Join Us Today</Typography>
                        <Typography variant="paragraph" color="blue-gray" className="text-lg font-normal">Enter your password .</Typography>
                    </div>
                    <form onSubmit={submit} className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2">
                        <div className="mb-1 flex flex-col gap-4">
                            {/* current passwored */}
                            <div className="mb-1 flex flex-col gap-3">
                                <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                                    Current Passwored
                                </Typography>
                                <Input
                                    name='current_password'
                                    value={newPassword.current_password}
                                    ref={myFocus}
                                    size="lg"
                                    placeholder="current password"
                                    onChange={handleChange}
                                    className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                                    labelProps={{
                                        className: "before:content-none after:content-none",
                                    }}
                                />
                                {newPassword.current_password.length < 1 && accept && <p className='error'>current password is required</p>}
                            </div>

                            {/* new password */}
                            <div className="mb-1 flex flex-col gap-3">
                                <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                                    New Password
                                </Typography>
                                <Input
                                    name='new_password'
                                    type='password'
                                    required
                                    value={newPassword.new_password}
                                    size="lg"
                                    onChange={handleChange}
                                    className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                                    labelProps={{
                                        className: "before:content-none after:content-none",
                                    }}
                                />
                            </div>

                            {/* confirmation password */}
                            <div className="mb-1 flex flex-col gap-3">
                                <Typography variant="small" color="blue-gray" className="-mb-3 font-medium">
                                    Confirmation Password
                                </Typography>
                                <Input
                                    name='new_confirm_password'
                                    type='password'
                                    required
                                    value={newPassword.new_confirm_password}
                                    size="lg"
                                    onChange={handleChange}
                                    className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                                    labelProps={{
                                        className: "before:content-none after:content-none",
                                    }}
                                />
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
                        <Button color='#1A2331' type='submit' className="mt-6" fullWidth>
                            Accept
                        </Button>
                    </form>

                </div>
            </section>
        </div>
    );
}

export default ChangePassword;