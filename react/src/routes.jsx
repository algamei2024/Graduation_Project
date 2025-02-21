import {
  HomeIcon,
  UserCircleIcon,
  TableCellsIcon,
  InformationCircleIcon,
  ServerStackIcon,
  RectangleStackIcon,

  Square2StackIcon,
  PhotoIcon,
  CodeBracketSquareIcon,
  GlobeAltIcon,
  GifIcon,
  ListBulletIcon,
} from "@heroicons/react/24/solid";
import { Home, Profile, Tables, Notifications, UpdateUser, CreateUser, ChangePassword } from "@/pages/dashboard";
import { SignIn, SignUp } from "@/pages/auth";

class Obj {
  div() {
    const a = document.createElement("div");
    return a;
  }

  image() {
    let img = document.createElement("img");
    img.setAttribute("src", "../public/img/image-1@2x.jpg");
    img.className = "img";
    return img;
  }
}

const icon = {
  class: "w-12 h-12 ml-1 text-inherit",
};

export const routes = [
  {

    // ammar adding

    title: 'dashboard design',
    design: {
      div: {

        icon: <Square2StackIcon {...icon} />,
        name: "حاوية",

        element: new Obj().div(),
      },
      img: {
        icon: <PhotoIcon {...icon} />,
        name: "صورة",

        element: new Obj().image()
      },

      button: {
        icon: <CodeBracketSquareIcon {...icon} />,
        name: "زر",

      },

      a: {
        icon: <GlobeAltIcon {...icon} />,
        name: "رابط",
        element: '<a class="a" href="#">رابط </a>',
      },
      p: {
        icon: <GifIcon {...icon} />,
        name: " النص",

        element: ' <p class="text">this  new text </p>',
      },
      table: {
        icon: <TableCellsIcon {...icon} />,
        name: "جدول",
        element: '<table class="table"><tr class="tr">  <td class="td">  </td><td class="td"></td>  </tr>  <tr class="tr">  <td class="td"></td><td class="td"></td>  </tr></table>',
      },
      list: {
        icon: <ListBulletIcon {...icon} />,
        name: "قائمة",
        element: "<ul ><li >1</li><li >2</li></ul>",
      },
    },

    // end ammar adding
  },
  {
    layout: "dashboard",
    pages: [
      {
        icon: <HomeIcon {...icon} />,
        name: "لوحة التحكم",
        path: "/home",
        element: <Home />,
      },
      {
        icon: <UserCircleIcon {...icon} />,
        name: "الملف الشخصي",
        path: "/profile",
        element: <Profile />,
      },
      {
        icon: <TableCellsIcon {...icon} />,
        name: "المستخدمين",
        path: "/tables",
        element: <Tables />,
      },
      {
        icon: <TableCellsIcon {...icon} />,
        name: "",
        path: "/changePassword",
        element: <ChangePassword />,
      },
      {
        icon: <UserCircleIcon {...icon} />,
        name: "",
        path: "/tables/:id",
        element: <UpdateUser />,
      },
      {
        icon: <UserCircleIcon {...icon} />,
        name: "",
        path: "tables/createuser",
        element: <CreateUser />,
      },
      {
        icon: <InformationCircleIcon {...icon} />,
        name: "الاشعارات",
        path: "/notifications",
        element: <Notifications />,
      },
    ],
  },
  {
    title: "auth pages",
    layout: "auth",
    pages: [
      {
        icon: <ServerStackIcon {...icon} />,
        name: "sign in",
        path: "/sign-in",
        element: <SignIn />,
      },
      {
        icon: <RectangleStackIcon {...icon} />,
        name: "sign up",
        path: "/sign-up",
        element: <SignUp />,
      },
    ],
  },
];

export default routes;
