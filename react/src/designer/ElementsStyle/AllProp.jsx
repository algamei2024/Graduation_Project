
import update from "../pages/dashboard/updatestyle";
import styleElement from "../pages/dashboard/styleElement";
export const Reset = (target) => {
  let c = window.getComputedStyle(target);
  console.log(c.backgroundColor);}

export const gathering = (target,prop) => {//قسم البكسلات من طول وعرض وغيره

  console.log(prop)
 update(styleElement,target,prop)
}
export const targetColor = (target, ele, prop) => {//تعديل خصائص حسب اسم الخاصيه مع اخذ قيمه الحدث كقيمه
  target.style[prop] = ele.target.value;
  console.log(target) 
}
export const targetInner = (target, ele, prop) => {
  target[prop] = ele.target.value;
}

export const targetPaddingAll = (target, ele, pref,object) => {

    
     const inputvale=ele.target.parentElement.querySelector("input").value;
      var marg={} 
       let newval
      pref.current.forEach(el => { 
         if(ele.value==="-color"){
          document.getElementById("bordercolor")
        }
        if(el.type=="radio"){
          update(styleElement,target,{position: "relative"})
        }
        if (el.checked) {
          const add=  ele.target.id;
        
        
        if(add=="increment-button"){
          newval=((target.style[el.value])?parseInt(target.style[el.value]):((object[el.value])?parseInt(object[el.value]):0))+1+parseInt(inputvale)
        }else{newval=((target.style[el.value])?parseInt(target.style[el.value]):((object[el.value])?parseInt(object[el.value]):0))-1-parseInt(inputvale)}
      
            const key = el.value; // e.g., "margin-left"
            const value = `${newval}px`; // e.g., "10px"
          
            marg[key] = value;
        }
    });
    


      update(styleElement,target,marg)

}

export const borderstyle = (target, ele, pref) => {

if(ele.target.id=="formIconSize"){ 
if(pref.current[0].checked&&pref.current[3].checked){ update(styleElement,target,{"border-top-right-radius":ele.target.value+"px"})}
if(pref.current[2].checked&&pref.current[3].checked){ update(styleElement,target,{"border-top-left-radius":ele.target.value+"px"})}
if(pref.current[0].checked&&pref.current[1].checked){ update(styleElement,target,{"border-bottom-right-radius":ele.target.value+"px"})}
if(pref.current[2].checked&&pref.current[1].checked){update(styleElement,target,{"border-bottom-left-radius":ele.target.value+"px"})}
 return ;}
var marg={};
if(ele.target.className=="radio"){
pref.current.forEach(el => { 
  if (el.checked) {
    let key="";
    for(let i=0;i<el.value.length-5;i++){
     key += el.value[i];
    }
   // e.g., "margin-left"
  const value = ele.target.value; // e.g., "10px"

  marg[key+"style"] = value;}
})
update(styleElement,target,marg)
}


 

}



export const targetBoxShadowColor = (target,pref) => {
let  Shadow ;
  if (target.nodeType === Node.TEXT_NODE) {
  Shadow="text-shadow"
  }else{
  Shadow="box-shadow"
  }
  
  pref.current.forEach(el => {
  const shadowjson={
    left:` -${pref.current[4].value}px ${pref.current[6].value}px ${pref.current[5].value}px ${document.getElementById("color").value}`,
    right:`  ${pref.current[4].value}px ${pref.current[6].value}px ${pref.current[5].value}px ${document.getElementById("color").value}`,
    top:`${pref.current[6].value}px -${pref.current[4].value}px ${pref.current[5].value}px ${document.getElementById("color").value}`,
    bottom:`${pref.current[6].value}px ${pref.current[4].value}px ${pref.current[5].value}px ${document.getElementById("color").value}`
  }
    if(el.checked)
      target.style[Shadow]=shadowjson[el.value];

    }

  
  )


}

export const display = (target, ele) => {
 if(ele=="remove"){
(target.style["display"])?target.style.removeProperty("display"):"";
(target.style["flex-wrap"])?target.style.removeProperty("flex-wrap"):"";
(target.style["justify-content"])?target.style.removeProperty("justify-content"):"";
(target.style["flex-direction"])?target.style.removeProperty("flex-direction"):"";

const inputs = document.getElementById("felx").querySelectorAll("input");
console.log(inputs)

inputs.forEach(input => {

    input.checked = false; // Found at least one checked input
  
});
 }else{

  update(styleElement,target,ele)
 }




}

export const targetTypeBorder = (target, prop) => {
  target.style.borderStyle = prop;
}
export const targetOnClickButton = (target, ele, prop) => {
  target.addEventListener(prop, function () {
      window.open('https://' + ele.target.value, '_blank');
  })
}
export const targetCursor = (target, prop, value) => {
  target.style[prop] = value;
}
export const targetScale = (target, ele, scref, YoN) => {
  if (YoN == "check") {
      if (ele.target.checked == true) {
          target.style.transition = 'transform 0.3s ease-in-out';
          target.addEventListener('mouseover', function () {
              target.style.transform = 'scale(1.1)';
          })
          target.addEventListener('mouseout', function () {
              target.style.transform = 'scale(1)';
          })
      }
      else {
          target.addEventListener('mouseover', function () {
              target.style.transform = 'scale(1)';
          })
      }
  }
  else {
      if (scref.current.checked) {
          target.addEventListener('mouseover', function () {
              target.style.transform = `scale(1.${ele.target.value})`;
          })
      }
  }
}
let tx = 0;
export const getSelected = (target) => {
  tx = target.ownerDocument.getSelection().toString();
  //console.log(target);
  x = target.ownerDocument.getSelection().getRangeAt(0).cloneContents();
  //console.log(x)

}
export const targetBIU = (target, wasm) => {
  if (tx != 0) {
      let temp = target.innerHTML;
      temp = temp.replace(tx, `<${wasm}>${tx}</${wasm}>`);
      target.innerHTML = temp;
      tx = 0;
  }
}
let x = 0;
export const getTarget = (event) => {
  //console.log(event.target.tagName);
  x = event;
}
let same = 0;
export const targetColorText = (target, ele) => {
  //console.log(x.target.textContent)
  if ((x.target.tagName == same && x.target.textContent == tx) || x.target.tagName == "SPAN") {
      x.target.style.color = ele.target.value;
      //console.log('first');
      //console.log(x.target.style.color);
  }
  else {
      let temp = target.innerHTML;
      temp = temp.replace(tx, `<span style='color:${ele.target.value}'>${tx}</span>`);
      target.innerHTML = temp;
      same = x.target.tagName;
  }
  same = x.target.tagName;
}
let divEditDeletedEl = document.createElement('div');
export const getList = (target, edList) => {
  //console.log(target)
  if (divEditDeletedEl.children.length > 0 || edList.current == null) {
      divEditDeletedEl.innerHTML = '';
      return;
  }
  let itemList = target;
  let inputEdit = document.createElement('input');
  let buttonDelete = document.createElement('button');
  inputEdit.style.cssText = 'padding:5px; margin:4px;border-radius:5px;';
  buttonDelete.innerHTML = 'حذف العنصر';
  buttonDelete.style.cssText = 'background-color:white;padding:5px; margin:10px;border-radius:5px;';
  divEditDeletedEl.classList.add('mb-6');
  inputEdit.setAttribute('type', 'text');
  inputEdit.value = target.textContent;
  inputEdit.onblur = (ele) => {
      if (!ele.target.value)
          return;
      itemList.textContent = ele.target.value;
      divEditDeletedEl.remove();
  }

  buttonDelete.onclick = () => {
      itemList.remove();
      divEditDeletedEl.remove();
  }
  divEditDeletedEl.appendChild(inputEdit);
  divEditDeletedEl.appendChild(buttonDelete);
  if (edList.current != null)
      edList.current.insertAdjacentElement('afterend', divEditDeletedEl)
  //console.log(edList.current)
}
export const addItem = (target, edList) => {
  let type = edList.current.children[0].value;
  let item = document.createElement('li');
  item.textContent = 'تمت إضافة عنصر جديد';
  item.style['list-style-type'] = type;
  target.appendChild(item);
}