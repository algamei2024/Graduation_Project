import { React, useEffect, useState } from "react";
import { IconButton } from "@material-tailwind/react";
import update from "./updatestyle";
import styleElement from "./styleElement";
import resizehadler from "./resizehadler";
import axios from "axios";
import Cookie from 'cookie-universal';








export function Home({ targ_css }) {
  const cookie = new Cookie();

  const [scrollPosition, setScrollPosition] = useState(0);

  const handleScroll = () => {
      setScrollPosition(window.scrollY);
  };

  useEffect(() => {
      // Add scroll event listener
      window.addEventListener('scroll', handleScroll);

      // Cleanup function to remove the listener on unmount
      return () => {
          window.removeEventListener('scroll', handleScroll);
      };
  }, []);
  
  const htmlcode=
  `

<div id="remove" > <svg   class="w-5 h-5  text-gray-800 dark:text-white font-bold" style="fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512 955.733333c-121.890133 0-227.584-43.8784-314.146133-130.440533C111.872 739.2768 68.266667 633.890133 68.266667 512c0-121.856 43.588267-227.549867 129.536-314.112C284.450133 111.854933 390.144 68.266667 512 68.266667c121.890133 0 227.2768 43.605333 313.2928 129.5872C911.854933 284.416 955.733333 390.109867 955.733333 512c0 121.924267-43.895467 227.328-130.474666 313.326933C739.328 911.837867 633.924267 955.733333 512 955.733333z m0-853.333333c-112.520533 0-210.1248 40.2432-290.065067 119.620267C142.6432 301.8752 102.4 399.479467 102.4 512c0 112.503467 40.226133 209.783467 119.586133 289.160533C301.909333 881.083733 399.496533 921.6 512 921.6c112.4864 0 209.7664-40.4992 289.1264-120.405333C881.1008 721.7664 921.6 624.4864 921.6 512c0-112.503467-40.516267-210.090667-120.439467-290.013867C721.783467 142.626133 624.503467 102.4 512 102.4z"  /><path d="M632.32 667.306667a33.979733 33.979733 0 0 1-24.2176-10.0864L512 560.452267l-96.1024 96.768a34.133333 34.133333 0 1 1-48.4352-48.093867l96.3584-97.041067-96.273067-96.273066a34.133333 34.133333 0 1 1 48.264534-48.264534L512 463.7184l96.187733-96.170667a34.133333 34.133333 0 1 1 48.264534 48.264534l-96.273067 96.273066 96.3584 97.041067A34.133333 34.133333 0 0 1 632.32 667.306667z"  /></svg></div>


<div id="add"> <svg  class="w-5 h-5  text-gray-800 dark:text-white font-bold" style="fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512.853333 955.733333H512c-121.890133 0-227.584-43.8784-314.146133-130.440533C111.872 739.2768 68.266667 633.890133 68.266667 512c0-121.856 43.588267-227.549867 129.536-314.112C284.450133 111.854933 390.144 68.266667 512 68.266667c121.890133 0 227.2768 43.605333 313.2928 129.5872C911.854933 284.416 955.733333 390.109867 955.733333 512c0 121.924267-43.895467 227.328-130.474666 313.326933C739.328 911.837867 634.197333 955.733333 512.853333 955.733333zM512 102.4c-112.520533 0-210.1248 40.2432-290.065067 119.620267C142.6432 301.8752 102.4 399.479467 102.4 512c0 112.503467 40.226133 209.783467 119.586133 289.160533C301.909333 881.083733 399.496533 921.6 512 921.6h0.853333c111.9232 0 208.913067-40.4992 288.290134-120.405333C881.1008 721.7664 921.6 624.4864 921.6 512c0-112.503467-40.516267-210.090667-120.439467-290.013867C721.783467 142.626133 624.503467 102.4 512 102.4z"  /><path d="M512.853333 715.946667a34.133333 34.133333 0 0 1-34.133333-34.133334v-136.533333h-136.533333a34.133333 34.133333 0 0 1 0-68.266667h136.533333V341.333333a34.133333 34.133333 0 0 1 68.266667 0v135.68H682.666667a34.133333 34.133333 0 0 1 0 68.266667h-135.68v136.533333a34.133333 34.133333 0 0 1-34.133334 34.133334z"  /></svg>
</div>

`

 

const set= document.createElement("div"); 




const [size, setSize] = useState({ x: 50, y: 50 });
const [x,setx]=useState(50)

useEffect(()=>{
const main=  document.getElementById("this")
main.addEventListener("mouseover",handlemouseover)
document.getElementById("this").parentElement.appendChild(set); 


},0);  
  



  

    

// const handler = (mouseDownEvent,dawntarg,cond) =>   {
//   const stage =dawntarg.parentElement;
//   const el = dawntarg.cloneNode(true);
//   stage.append(el)

  
//   const copyel=dawntarg;
//   if(cond=="move"){
//     document.getElementById("remove").remove();
//   document.getElementById("add").remove();
//   document.getElementById("copy").remove();
//   }
//   if(cond=="copy"){
//     document.getElementById("remove").remove();
//   document.getElementById("add").remove();
//   document.getElementById("move").remove();
//   }
  
//   const elCoords = { x: 0, y: 0 };
  
//   function moveVertically(movement) {
//     elCoords.y = movement;

//   }
  
  

//   function moveHorizontally(movement) {
//     elCoords.x = movement;
//   }
  
//   const onMouseMove= (e)=> {
  
//     const targRect = el.getBoundingClientRect();
//     const a=  document.elementFromPoint(el.getBoundingClientRect().left, el.getBoundingClientRect().top+el.getBoundingClientRect().height);
//     a.style["border"]="3px solid red"
//     moveHorizontally(e.clientX-mouseDownEvent.clientX);
//     moveVertically(e.clientY-mouseDownEvent.clientY-targRect.height);
    
//     set.style.bottom = `${window.innerHeight - targRect.top}px`;
//     set.style.left = `${targRect.left}px`;
    
    
//       update(styleElement,el,{position:"relative",transform:`translate(${(elCoords.x)}px, ${elCoords.y}px)`,"z-index":"3000"})

//        a.style.removeProperty("border")
  

//   }
// function onMouseUp(e) {
//   stage.removeEventListener("mousemove", onMouseMove);
//   set.removeEventListener("mousedown", handler);
//   if(cond=="copy"){
  
//   const a=  document.elementFromPoint(el.getBoundingClientRect().left, el.getBoundingClientRect().top+el.getBoundingClientRect().height);

// const rect = el.getBoundingClientRect();
// const newLeft = Math.min(Math.max(0, ((e.x - rect.left) / rect.width) * 100), 100);
// const newTop = Math.min(Math.max(0, ((e.y - rect.top)/ rect.height) * 100), 100);

// update(styleElement,el,{position:"absolute",top:`${newTop}%`,left:`${newLeft}%`,width:`${rect.width}px`,height:`${rect.height}px`})
// a.appendChild(el)
// el.style.removeProperty("transform");
//   }else{
//     update(styleElement,el,{position:"relative",top:`${newTop}%`,left:`${newLeft}%`})

//   }
    
//   }
  

//   stage.addEventListener("mouseup", onMouseUp, { once: true });
//   stage.addEventListener("mousemove", onMouseMove);

// };


 function handlemouseover (event){
  const targ=event.target;


  const { offsetX, offsetY, target } = event;
    const borderWidth = 10;
  


  
  
const mouseleavehandler = function() {
   
      
  // targ.removeEventListener("mousedown",resizehadler);
  // targ.removeEventListener("mousedown", handler);
        try{
          const classname=targ.className?targ.className:""
           if(classname!=""){ 
          targ.classList.remove("div") 
        
          
         }else{
          
             targ.removeAttribute("class");
         }
        }catch(err){

        }
        
    
    targ.removeEventListener("mouseleave", mouseleavehandler);
     // Remove the event listener
};




   
  if(targ.id!="this"){
  
    
     

    if (
      offsetX >= target.clientWidth - borderWidth &&
   
      offsetY <= target.clientHeight - borderWidth
  ) {
    update(styleElement,targ,{cursor: "nwse-resize"})
  }else{
  
    
      update(styleElement,targ,{cursor: "auto"})
    
    }


     set.className="border border-gray-200 rounded-lg"
     set.innerHTML=htmlcode
  
   
   set.id="set"

   const targRect = targ.getBoundingClientRect();
  //  ياخذ موقع العنصر بل االنسبه للشاشة
    

   set.style.bottom = `${window.innerHeight - targRect.top}px`;
   set.style.left = `${targRect.left}px`;

    
       if(targ.className.length>0){
         targ.classList.add("div")
       }else{
        targ.className="div"
       }
         


  targ.addEventListener("mousedown",resizehadler);

  // document.getElementById("move").addEventListener("mousedown",function(mouseDownEvent){
  //   handler(mouseDownEvent,targ.cloneNode(true),"move")
  
  // });  
  // document.getElementById("copy").addEventListener("mousedown",function(mouseDownEvent){
  //   handler(mouseDownEvent,targ,"copy")
  
  // }); 
  targ.addEventListener("mouseleave", mouseleavehandler);

   document.getElementById("remove").addEventListener("click",function () {
     targ.remove()
   });
   document.getElementById("add").addEventListener("click",function () {
    targ_css(targ);
  
  
   });

  }  

  





}


// const Chatbox = () => {
//   const [isOpen, setIsOpen] = useState(false);

//   const toggleDropdown = () => {
//       setIsOpen(!isOpen);
//   };

//   return (
//       <div className=" mt-3  rounded-md duration-300 cursor-pointer" onClick={toggleDropdown}>
          
//               <div className="text-[15px] w-full h-100 text-gray-200 font-bold bg-black">Chatbox</div>
          
    
//           {isOpen && (
//               <div className="text-left text-sm mt-2 w-full mx-auto text-gray-900 bg-white font-bold" id="submenu" >
//                   <h1 className="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">Social</h1>
//                   <h1 className="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">Personal</h1>
//                   <h1 className="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">Friends</h1>
//               </div>
//           )}
//       </div>
//   );
// };


// i'm addning
const [data, setData] = useState('');

useEffect(() => {

  const params = new URLSearchParams(window.location.search);
  let dataFromUrl = params.get('data');
  if (dataFromUrl) {
    dataFromUrl = JSON.parse(dataFromUrl);

    cookie.set('trader', dataFromUrl.token);
    console.log('the name file', dataFromUrl.nameFile);
  }

  const data = {
    'id': dataFromUrl.trader_id,
    'nameFile': dataFromUrl.nameFile,
  };

  const getData = async () => {
    await axios.post('http://127.0.0.1:8000/api/getData', data, {
      headers: {
        Authorization: 'Bearer ' + cookie.get('trader')
      }
    }).then(res => {
      console.log('response for data ', res);
      setData(res.data);

      
      styleElement.innerHTML += res.data.css;
      

    })
      .catch(err => console.log('error from get data', err));
  };

  getData();



  return () => {
    document.head.removeChild(style);
  }

}, []);

async function sendDataDesign() {
  const cardCode = document.querySelector('#this').innerHTML;
  const encodeCardCode = encodeURIComponent(cardCode);
  const nameFile = data.nameFile;
  const formData = new FormData();
  formData.append('nameFile', nameFile);
  formData.append('dataCode', encodeCardCode);


  const token = cookie.get('trader');

  console.log('token', token);


  await axios.post('http://127.0.0.1:8000/api/saveDataDesign', formData, {
    // withCredentials: true,
    headers: {
      Authorization: 'Bearer ' + token,
      // 'Content-Type': 'application/json',
    }
  }).then(res => {
    console.log('the res ', res);
    window.location.href = 'http://127.0.0.1:8000/admin';
  })
    .catch(err => {
      console.log('خطا في الارسال :=>', err);
    });

}

// end i'm adding

  // <div>
  //         <div class="header" >
  //           <h1>My Website</h1>
  //           <p>A website created by me.</p>
  //         </div>

  //         <div class="navbar">
  //           <a href="#">Link</a>
  //           <a href="#">Link</a>
  //           <a href="#">Link</a>
  //           <a href="#" class="right">Link</a>
  //         </div>

  //         <div class="row">
  //           <div class="side">
  //             <h2>About Me</h2>
  //             <h5>Photo of me:</h5>
  //             <div class="fakeimg" >Image</div>
  //             <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
  //             <h3>More Text</h3>
  //             <p>Lorem ipsum dolor sit ame.</p>
  //             <div class="fakeimg" >Image</div><br />
  //             <div class="fakeimg" >Image</div><br />
  //             <div class="fakeimg" >Image</div>
  //           </div>
  //           <div class="main">
  //             <h2>TITLE HEADING</h2>
  //             <h5>Title description, Dec 7, 2017</h5>
  //             <div class="fakeimg" >Image</div>
  //             <p>Some text..</p>
  //             <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
  //             <br />
  //             <h2>TITLE HEADING</h2>
  //             <h5>Title description, Sep 2, 2017</h5>
  //             <div class="fakeimg" >Image</div>
  //             <p>Some text..</p>
  //             <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
  //           </div>
  //         </div>
    
  //       </div>
  return (
    <>
     <div className="my-4  rounded-sm  border border-blue-gray-200 w-full   " id="this"  >
    {data ? (
          <div>
            <div dangerouslySetInnerHTML={{ __html: data.html }} />
          </div>
        ) : (
          <p>لا توجد بيانات.</p>
        )}


      

</div>

<button
          size="lg"
          color="white"
          className="fixed bottom-2 btn bg-black text-white h-12  right-8  z-40 rounded-md w-32 shadow-blue-gray-900/10"
          onClick={() =>sendDataDesign() }
          
        >
        حفظ التصميم
        </button>
      
      {/* </div>
      <button onClick={sendDataDesign}>save from home</button> */}
    </>
  );
}

export default Home;

