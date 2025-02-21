


function update(dom,object,styles){



  for (let property in styles) {

    object.style[property] = styles[property];
  

}

//   try {


// let id= object && object.id ? object.id : "";



//   for (let rule of dom.sheet.cssRules) {
//     if (rule.selectorText === "#"+id) {
       
    
      
//         return 1; 
//     }
  
    // Array.from(object.classList).forEach(className => {
    //   if (rule.selectorText === "."+className && rule.selectorText !=".div") {
       
    //     for (let property in styles) {
  
    //       rule.style[property] = styles[property];
        
          
    //   }
        
    //       return 1; 
    //   }
    // });
  



  // } catch (error) {
    
  // }
  

  

  }

export default update;
