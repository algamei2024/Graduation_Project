
import React, { useState } from 'react';
import { useEffect } from 'react';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';

 function  TextEditorReact ({ch},{update}) {
    const [editorHtml, setEditorHtml] = useState('');
    
     const handleChange = (html) => {
    let modifiedText="";
  



if(ch.childNodes.length==1){
  let bolclass=false;
  Array.from(ch.parentElement.classList).forEach(className => {
    if(className=="ql-editor"){
    bolclass=true;
    }
  })
  if(!bolclass){
    ch.parentElement.classList.add("ql-editor")
  }
  modifiedText=html
ch.innerHTML=modifiedText;
} 

  
    
    



setEditorHtml(html);
  }


  useEffect(()=>{ 
    const textContent = ch.childNodes;

            // مصفوفة لتخزين النصوص
            let allText = [];

            // حلقة لجمع النصوص
            for (let node of textContent) {

                if (node.nodeType === Node.TEXT_NODE) {
                    allText.push(node.nodeValue.trim());
                }
            }

    const combinedText = allText.join(' ');
          

            // عرض النص المقسم في المنطقة المخصصة
        
    setEditorHtml(combinedText);

    
  },[ch])
  const [isRtl, setIsRtl] = useState(false); // State for direction


  const toggleDirection = () => {
      setIsRtl(!isRtl); // Toggle between RTL and LTR
  document.getElementById("get").querySelector("p").className=isRtl?"text-left": 'text-right'
  };
    
    return (
        <div>
            <button onClick={toggleDirection}>
                 {isRtl ? 'eng  LTR' : 'عربي RTL'}
            </button>
            <div dir={isRtl ? 'rtl' : 'ltr'} id="get"> {/* Set direction here */}
                <ReactQuill 
                    value={editorHtml} 
                    onChange={handleChange} 
                    modules={TextEditorReact.modules} 
                    formats={TextEditorReact.formats} 
                />
            </div>
            <div className="editor-output">
                <h2>Output:</h2>
                <div dangerouslySetInnerHTML={{ __html: editorHtml }} />
            </div>
        </div>
    );
};

// Specify the Quill modules and formats you want to use

TextEditorReact.modules = {
  toolbar: [
      [{ header: '1' }, { header: '2' }, { font: [] }],
      [{ size: [] }],
      ['bold', 'italic', 'underline', 'strike', 'blockquote'],
      [{ list: 'ordered' }, { list: 'bullet' }],
      ['link', 'image', 'video'],
      [{ color: [] }, { background: [] }], // Color and background color options
      ['clean'],
  ],
};

TextEditorReact.formats = [
  'header', 'font', 'size',
  'bold', 'italic', 'underline', 'strike', 'blockquote',
  'list', 'bullet', 'indent',
  'link', 'image', 'video',
  'color', 'background' // Include colors in formats
];
export default TextEditorReact;