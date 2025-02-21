


//   const [size, setSize] = useState({ x: 100, y: 100 });
  
// useEffect(()=>{

    
//     document.head.appendChild(styleElement);
// });  
    

  

//   const dynamicStyles =`
// .layout {
//   width: ${size.x}px;
//   height: ${size.y}px;
//   position: relative;

//   border: solid red 1px;
// }

// `;
//   styleElement.innerHTML = dynamicStyles;
  

//   const handler = (mouseDownEvent) => {
    
//     const startSize = size;
//     const startPosition = { x: mouseDownEvent.pageX, y: mouseDownEvent.pageY };
          
//     const targetElement = document.elementFromPoint(startPosition.x, startPosition.y);
    
//     if(targetElement.id!=""){
//       const element=  document.getElementById(targetElement.id)
//       setSize(currentSize => ({ 
//   x:element.offsetWidth,
//   y: element.offsetHeight
// }));
//     }
    
  
//     function onMouseMove(mouseMoveEvent) {

      

      
      
    
      
//       setSize(currentSize => ({ 
//         x: startSize.x - startPosition.x + mouseMoveEvent.pageX, 
//         y: startSize.y - startPosition.y + mouseMoveEvent.pageY 
//       }));
    
//     }
//     function onMouseUp() {
//       targetElement.removeEventListener("mousemove", onMouseMove);
//       // uncomment the following line if not using `{ once: true }`
//       // document.body.removeEventListener("mouseup", onMouseUp);
//     }
    
//     targetElement.addEventListener("mousemove", onMouseMove);
//     targetElement.addEventListener("mouseup", onMouseUp, { once: true });
  
//   };
//   if(document.getElementById("this")){
//   document.getElementById("this").addEventListener("mouseover",function(event){
//     const targ=event.target;
//     console.log(targ)
    
//     if(targ.id!=""){
    
//   document.getElementById(targ.id).addEventListener("mousedown",handler);


//     }

//   })}
