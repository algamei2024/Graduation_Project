import {
  Card,
  CardHeader,
  CardBody,
  Button,
  Typography,
  Avatar,
  Chip,
  Tooltip,
  Progress,
} from "@material-tailwind/react";
import { PlusIcon, UserCircleIcon } from "@heroicons/react/24/solid";
import { EllipsisVerticalIcon } from "@heroicons/react/24/outline";
import { authorsTableData, projectsTableData, useAuthorsData } from "@/data";
import Loading from "@/refreshPage/loading";
import { Link } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "axios";
import Cookie from 'cookie-universal';

export function Tables() {
  // const [testRun, setTestRun] = useState(0);//لتحديث الصفحة بعد عملية الحذف
  const data = useAuthorsData();
  const [users, setUsers] = useState(data);
  const [currentOwner, setCurrentOwner] = useState({
    name: '',
    email: '',
    role: '',
  });


  //تنسيق صورة المستخدم اذا لم يكن لديه صورة
  const icon = {
    className: "w-6 h-6 text-inherit",
  };

  // console.log('users ',users);
  useEffect(() => {
    setUsers(data);
  }, [data]);


  //الحصول على المستخدم الحالي
  useEffect(() => {
    const getCurrentOwner = async () => {
      await axios.post('http://127.0.0.1:8000/api/admin/me', null, {
        headers: {
          Authorization: 'Bearer ' + token
        }
      })
        .then(res => {
          setCurrentOwner(res.data);
          console.log('currentOwner is ', res);
        })
        .catch(err => console.log(err));
    };

    getCurrentOwner();
  }, []);



  const cookie = Cookie();
  const token = cookie.get('Bearer');


  async function deleteUser(id) {
    try {
      let res = await axios.delete(`http://127.0.0.1:8000/api/admin/${id}`, {
        headers: {
          Authorization: 'Bearer ' + token
        }
      }).then(data => {
        // setTestRun((prev) => prev + 1);
        console.log('تم حذف المستخدم بنجاح');

        //الغرض من هذا السطر هو تحديث الصفحة بالبيانات الجديدة بعد عملية الحذف
        setUsers((prevUsers) => prevUsers.filter(user => user.id !== id));

      });
    } catch (err) {
      console.log('running error', err);
    }
  }


  ////test admin found from website
  // useEffect(() => {
  //   const testAdmin = async () => {
  //     await axios.get(`http://127.0.0.1:8000/testAdminFound`, {
  //       headers: {
  //         Authorization: 'Bearer ' + token
  //       }
  //     }).then(data => console.log('test admin found', data))
  //       .catch(err => console.log('error from test admin found ', err))
  //   }
  //   testAdmin();
  // }, []);




  const userData = users.map(
    (user, key) => {
      const className = `py-3 px-5 ${key === authorsTableData.length - 1
        ? ""
        : "border-b border-blue-gray-50"
        }`;

      return (
        <tr key={user.name}>
          <td className={className}>
            <div className="flex items-center gap-4">
              {/* {user.img ? <Avatar src={user.img} alt={user.name} size="sm" variant="rounded" />
                :  */}
              <UserCircleIcon {...icon} />
              {/* } */}
              <div>
                <Typography
                  variant="small"
                  color="blue-gray"
                  className="font-semibold"
                >
                  {user.name}
                </Typography>
                <Typography className="text-xs font-normal text-blue-gray-500">
                  {user.email}
                </Typography>
              </div>
            </div>
          </td>
          <td className={className}>
            <Typography className="text-xs font-semibold text-blue-gray-600">
              {user.job[0]}
            </Typography>
            <Typography className="text-xs font-normal text-blue-gray-500">
              {user.job[1]}
            </Typography>
          </td>
          <td className={className}>
            <Chip
              variant="gradient"
              color={user.status === 'active' ? "green" : "blue-gray"}
              value={user.status}
              className="py-0.5 px-2 text-[11px] font-medium w-fit"
            />
          </td>
          <td className={className}>
            <Typography className="text-xs font-semibold text-blue-gray-600">
              {user.date}
            </Typography>
          </td>
          <td className={className} style={{ display: 'flex', justifyContent: 'space-evenly' }}>

            <span style={{ color: 'red', cursor: 'pointer' }} onClick={() => deleteUser(user.id)}>X</span>
            <Link to={`${user.id}`} style={{ textDecoration: 'none' }}>
              <span style={{ color: 'green', fontSize: '20px', cursor: 'pointer' }}>-</span>
            </Link>
            <Typography className="text-xs font-normal text-blue-gray-500">
              {user.role}
            </Typography>

          </td>
        </tr>
      );
    }
  );
  return (
    <div className="mt-12 mb-8 flex flex-col gap-12">
      <Card>
        <CardHeader variant="gradient" color="gray" className="mb-2 p-6">
          <Typography variant="h6" color="white">
            قائمة المستخدمين
          </Typography>
        </CardHeader>
        {/* فحص ما اذا كان الشخص الداخل احد المسؤولين ام من التجار */}
        {currentOwner.role === 'owner' ?
          (
            <div className="flex justify-end p-4">
              <Link to='/dashboard/tables/createuser' >
                <Button
                  color="#1A2331"
                  className="flex items-center h-12 px-6" // تعيين margin أعلى إلى صفر
                >
                  <PlusIcon className="h-5 w-5 mr-2" />
                  إضافة مستخدم
                </Button>
              </Link>
            </div>
          )
          : ""
        }
        <CardBody className="overflow-x-scroll px-0 pt-0 pb-2">
          <table className="w-full min-w-[640px] table-auto">
            <thead>
              <tr>
                {["author", "function", "status", "employed", "action"].map((el) => (
                  <th
                    key={el}
                    className="border-b border-blue-gray-50 py-3 px-5 text-left"
                  >
                    <Typography
                      variant="small"
                      className="text-[11px] font-bold uppercase text-blue-gray-400"
                    >
                      {el}
                    </Typography>
                  </th>
                ))}
              </tr>
            </thead>
            <tbody>

              {/* كود معقد ولكنه اكثر حماية */}
              {/* {currentOwner? 
                        currentOwner.role==='admin'?
                          users.length === 0 ?
                            (<tr><td colSpan='5'>{<Loading fullPage={false} />}</td></tr>)
                            :users.length <= 1 && loading ?
                              (<tr><td colSpan='5'>No Users Found</td></tr>)
                              :userData
                        : (<tr><td colSpan='5'>أنت غير مخول برؤية المستخدمين</td></tr>)
                  :""
            } */}

              {users.length === 0 ?
                (<tr><td colSpan='5'>{<Loading fullPage={false} />}</td></tr>)
                : users.length <= 1 && loading ?
                  (<tr><td colSpan='5'>No Users Found</td></tr>)
                  : userData
              }
            </tbody>
          </table>
        </CardBody>
      </Card>

      {/* المقطع الثاني في صفحة المستخدمين */}
      {/* <Card>
        <CardHeader variant="gradient" color="gray" className="mb-8 p-6">
          <Typography variant="h6" color="white">
            Projects Table
          </Typography>
        </CardHeader>
        <CardBody className="overflow-x-scroll px-0 pt-0 pb-2">
          <table className="w-full min-w-[640px] table-auto">
            <thead>
              <tr>
                {["companies", "members", "budget", "completion", ""].map(
                  (el) => (
                    <th
                      key={el}
                      className="border-b border-blue-gray-50 py-3 px-5 text-left"
                    >
                      <Typography
                        variant="small"
                        className="text-[11px] font-bold uppercase text-blue-gray-400"
                      >
                        {el}
                      </Typography>
                    </th>
                  )
                )}
              </tr>
            </thead>
            <tbody>
              {projectsTableData.map(
                ({ img, name, members, budget, completion }, key) => {
                  const className = `py-3 px-5 ${key === projectsTableData.length - 1
                    ? ""
                    : "border-b border-blue-gray-50"
                    }`;

                  return (
                    <tr key={name}>
                      <td className={className}>
                        <div className="flex items-center gap-4">
                          <Avatar src={img} alt={name} size="sm" />
                          <Typography
                            variant="small"
                            color="blue-gray"
                            className="font-bold"
                          >
                            {name}
                          </Typography>
                        </div>
                      </td>
                      <td className={className}>
                        {members.map(({ img, name }, key) => (
                          <Tooltip key={name} content={name}>
                            <Avatar
                              src={img}
                              alt={name}
                              size="xs"
                              variant="circular"
                              className={`cursor-pointer border-2 border-white ${key === 0 ? "" : "-ml-2.5"
                                }`}
                            />
                          </Tooltip>
                        ))}
                      </td>
                      <td className={className}>
                        <Typography
                          variant="small"
                          className="text-xs font-medium text-blue-gray-600"
                        >
                          {budget}
                        </Typography>
                      </td>
                      <td className={className}>
                        <div className="w-10/12">
                          <Typography
                            variant="small"
                            className="mb-1 block text-xs font-medium text-blue-gray-600"
                          >
                            {completion}%
                          </Typography>
                          <Progress
                            value={completion}
                            variant="gradient"
                            color={completion === 100 ? "green" : "gray"}
                            className="h-1"
                          />
                        </div>
                      </td>
                      <td className={className}>
                        <Typography
                          as="a"
                          href="#"
                          className="text-xs font-semibold text-blue-gray-600"
                        >
                          <EllipsisVerticalIcon
                            strokeWidth={2}
                            className="h-5 w-5 text-inherit"
                          />
                        </Typography>
                      </td>
                    </tr>
                  );
                }
              )}
            </tbody>
          </table>
        </CardBody>
      </Card> */}
    </div>
  );
}

export default Tables;
