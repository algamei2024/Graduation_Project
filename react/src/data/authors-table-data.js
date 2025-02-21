import { useState, useEffect } from 'react';
import axios from "axios";
import Cookie from 'cookie-universal';



//مسؤولة عن جلب البيانات
export const fetchAuthorsData = async () => {
  const cookie = Cookie();
  const token = cookie.get("Bearer");

  try {
    const response = await axios.post(`http://127.0.0.1:8000/api/admin/getAllAdmins`, null, {
      headers: {
        Authorization: 'Bearer ' + token
      }
    }).catch(err => console.log('error from getAllAdmins', err));


    console.log('response admins ', response);

    return response.data.admins.map((author) => ({
      id: author.id,
      img: author.photo,
      name: author.name,
      email: author.email,
      role: author.role,
      job: ["Manager", "Organization"],
      status: author.status,
      // date: new Date().toISOString().split('T')[0],//طباعة التاريخ بالشكل التالي : '2024-08-28'
      date: author.created_at?.split('T')[0],//طباعة التاريخ بالشكل التالي : '2024-08-28'
    }));
  } catch (error) {
    console.error("Error fetching the data", error);
    return [];
  }
};

// تعبئة البيانات داخل الحالة
export const useAuthorsData = () => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      const data = await fetchAuthorsData();
      setUsers(data);
    };
    fetchData();
  }, []);

  return users;
};

export const authorsTableData = [
  {
    img: "/img/team-2.jpeg",
    name: "John Michael",
    email: "john@creative-tim.com",
    job: ["Manager", "Organization"],
    online: true,
    date: "23/04/18",
  },
  {
    img: "/img/team-1.jpeg",
    name: "Alexa Liras",
    email: "alexa@creative-tim.com",
    job: ["Programator", "Developer"],
    online: false,
    date: "11/01/19",
  },
  {
    img: "/img/team-4.jpeg",
    name: "Laurent Perrier",
    email: "laurent@creative-tim.com",
    job: ["Executive", "Projects"],
    online: true,
    date: "19/09/17",
  },
  {
    img: "/img/team-3.jpeg",
    name: "Michael Levi",
    email: "michael@creative-tim.com",
    job: ["Programator", "Developer"],
    online: true,
    date: "24/12/08",
  },
  {
    img: "/img/bruce-mars.jpeg",
    name: "Bruce Mars",
    email: "bruce@creative-tim.com",
    job: ["Manager", "Executive"],
    online: false,
    date: "04/10/21",
  },
  {
    img: "/img/team-2.jpeg",
    name: "Alexander",
    email: "alexander@creative-tim.com",
    job: ["Programator", "Developer"],
    online: false,
    date: "14/09/20",
  },
];

// const authorsTableData = await fetchAuthorsData();

console.log('authorsTableData ', authorsTableData);

export default authorsTableData;
