

  function generateRandomId(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzahahfxhgafsg';
    let randomId = '';
    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        randomId += characters[randomIndex];
    }
    return randomId;
  }

  

function update(dom,object,styles){

  try {
const newid= generateRandomId(5)

let id= object && object.id ? object.id : "";



  for (let rule of dom.sheet.cssRules) {
    if (rule.selectorText === "#"+id) {
       
      for (let property in styles) {

        rule.style[property] = styles[property];
      
        
    }
      
        return 1; 
    }
  
    // Array.from(object.classList).forEach(className => {
    //   if (rule.selectorText === "."+className && rule.selectorText !=".div") {
       
    //     for (let property in styles) {
  
    //       rule.style[property] = styles[property];
        
          
    //   }
        
    //       return 1; 
    //   }
    // });
  }



  object.id=newid;


  let ganral=`#${object.id}{`
  for (const property in styles) {
    if (styles.hasOwnProperty(property)) {
    
        const kebabCaseProperty = property;
        ganral += `
    ${kebabCaseProperty}: ${styles[property]};`;
    }
}ganral+=`}`
  
  
  dom.sheet.insertRule
  (ganral, dom.sheet.cssRules.length);



  } catch (error) {
    
  }
  
  return 0;
  

  }

export default update;
