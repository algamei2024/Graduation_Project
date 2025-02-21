const dargcss={
  ".layout":{
left: "200px",
top: "200px",
width: "100px",
    
height: "100px", 
cursor: "auto",
position:"absolute",
border: "solid red 1px"

},


    ".setting":{
      width: "100px",
    
      height: "100px", 
    

    },
    "#set":{
      width: "50px",
    
    
      display: "flex",
    
      position:"fixed",
      background: "aqua",
    "  justify-content":"space-between",
      "z-index":"4000",
    },
    "#remove":{
    
    cursor: "pointer",
    },
    "#move":{
      cursor: "move"  ,
    },
    "#copy":{
      cursor: "move"  ,
    
    
      
    },
    "#add":{
      cursor: "pointer"  ,
    
  

    }

    ,
    "#draghandle": {

      width: "10px",
      height: "10px",
      "background-color":" lightblue",
      position: "absolute",
      bottom: "0px",
      right:"0px",
      transform: "translate(-50%, -50%)",
      "text-align": "center", 
      cursor: "move",
    
      
    },
    ".div":{
  
      border: "3px solid rgb(11, 167, 229)",
    
    
    },
    ".lab_pho":{
      border: "3px solid rgb(11, 167, 229)",
    },
   ".imag":{
    width:"100%",
    height:"100%",
    

   }
   ,
   ".fakeimg":{
  height:"60px",
   },
   ".butnn":{
     width:"100%",
     height:"100%",
     left:"0px",
     top:"0px",

      "background-color": "#007bff",
      "color": "white",
      "padding": "10px 20px",
      "border": "none",
      "border-radius": "5px",
      "cursor": "pointer",
      "transition": "background-color 0.3s",
    
  },
    

   ".a":{
    width:"100%",
    height:"100%",
    left:"0px",
    top:"0px",
    "text-align": "center",
   
  }

,


  ".card": {
    "box-shadow": "0 4px 8px 0 rgba(0, 0, 0, 0.2)",
    "width": "300px",
    "height": "400px", 
    "margin": "auto",
    "text-align": "center",
    "font-family": "arial",
    "position":"absolute"
  },

  
    ".header": {
      "padding": "80px",
      "text-align": "center",
    
      "background": "#1abc9c",
      "color": "white",
  
    },
    ".header h1": {
      "font-size": "40px",
    },
    ".navbar": {
      "overflow": "hidden",
      "background-color": "#333",
      
    },
    ".navbar a": {
      "float": "left",
      "display": "block",
      "color": "white",
      "text-align": "center",
      "padding": "14px 20px",
      "text-decoration": "none"
    },
    ".navbar a.right": {
      "float": "right"
    },
    ".navbar a:hover": {
      "background-color": "#ddd",
      "color": "black"
    },
    ".row": {
      "display": "-ms-flexbox",
      "display": "flex",
      "-ms-flex-wrap": "wrap",
      "flex-wrap": "wrap"
    },
    ".side": {
      "-ms-flex": "30%",
      "flex": "30%",
      "background-color": "#f1f1f1",
      "padding": "20px"
    },
    ".main": {
      "-ms-flex": "70%",
      "flex": "70%",
      "background-color": "white",
      "padding": "20px"
    },
    ".fakeimg": {
      "background-color": "#aaa",
      "width": "100%",
      "padding": "20px"
    },
    ".footer": {
      "padding": "20px",
      "text-align": "center",
      "background": "#ddd"
    },
    "@media screen and (max-width: 700px)": {
      ".row": {
        "flex-direction": "column"
      }
    },
    "@media screen and (max-width: 400px)": {
      ".navbar a": {
        "float": "none",
        "width": "100%",
      
      }
    },
    ".myborder":{
      border: "3px solid rgb(11, 167, 229)",
    }
  
}
export default dargcss;