import styleElement from "./styleElement";

function generateRandomId(length) {
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzahahfxhgafsg';
  let randomId = '';
  for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length);
      randomId += characters[randomIndex];
  }
  return randomId;
}


export default function absoluteconvert () {
  const card=document.getElementById("this")
  
  const allElements=card.querySelectorAll("*");

  let ganral=``;
  
  
   allElements.forEach(element => {

    
    const rect = element.parentElement.getBoundingClientRect();
    const x = element.getBoundingClientRect();
     const newLeft = Math.min(Math.max(0, (((x.left)-rect.left) / element.parentElement.offsetWidth) * 100), 100);
    const newTop = Math.min(Math.max(0, ((x.top-rect.top)/ element.parentElement.offsetHeight) * 100), 100);
    const newWidth = (x.width / rect.width) * 100;
    const newHeight = (x.height / rect.height) * 100;
  
  if(element.id!=""){
    
      let styles=`
      left:${newLeft}%;
      top:${newTop}%;
      
      width:${newWidth}%;
      height:${newHeight}%;
      position:relative;
      `;
      for (let rule of styleElement.sheet.cssRules) {
        if (rule.selectorText === "#"+element.id) {
           
          for (let property in styles) {
    
            rule.style[property] = styles[property];
          
            
        }
          
          
        }
      
    
      }
    
  }else{

  element.id=generateRandomId(5);

  
   ganral+=`#${element.id}{
    left:${newLeft}%;
    top:${newTop}%;

    width:${newWidth}%;
    height:${newHeight}%;

    
  
  
    position: relative;
    

  }`  
}
});
ganral.trim().split('}').forEach(rule => {
  if (rule) {
      styleElement.sheet.insertRule(rule.trim() + '}', styleElement.sheet.cssRules.length);
  }
});
  console.log(ganral)

}
