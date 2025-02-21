import { useDrag, useDrop } from "react-dnd";
import React, { useState } from "react";
import styleElement from "../../pages/dashboard/styleElement";
import routes from "@/routes";


function generateRandomId(length) {
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzahahfxhgafsg';
  let randomId = '';
  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    randomId += characters[randomIndex];
  }
  return randomId;
}
const Note = ({ not }) => {
  const [type, settype] = useState(not)
  const [{ isDragging, didDrop }, drag] = useDrag(() => ({
    type: "notes",
    item: { name: not },
    end: (item, monitor) => {

      if (item) {


        const dropPosition = monitor.getClientOffset();


        const targetElement = document.elementFromPoint(dropPosition.x, dropPosition.y);
        const rect = targetElement.getBoundingClientRect();
        const react_drop = document.getElementById('this').getBoundingClientRect();
        if ((dropPosition.y - react_drop.top) > -1 && (dropPosition.x - react_drop.left) > -1) {


          const newDiv = routes[0].design[not].element.cloneNode(true);;



          newDiv.id = generateRandomId(5);

          targetElement.appendChild(newDiv);



          const newLeft = Math.min(Math.max(0, ((dropPosition.x - rect.left) / rect.width) * 100), 100);
          const newTop = Math.min(Math.max(0, ((dropPosition.y - rect.top) / rect.height) * 100), 100);

          styleElement.sheet.insertRule
            (`
#${newDiv.id}{  
left: ${newLeft}%;
top:${newTop}%;
width: 100px;

height: 100px; 
cursor: auto;

position: relative;

  }`, styleElement.sheet.cssRules.length);



        }


      }

    },

    collect: (monitor) => ({
      position: monitor.getClientOffset(),
      isDragging: monitor.isDragging()
    }),
  }), [])

  return (
    <>
      <div ref={drag} style={{ display: "flex", justifyContent: "center", alignItems: "center" }} ><div><p >{routes[0].design[type].name}</p></div><div>{routes[0].design[type].icon}</div> </div>
    </>
  )
}
export default Note;