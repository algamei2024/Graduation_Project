import React, { useEffect } from 'react'
import './Basic.css';
import { useRef } from 'react';
import { borderstyle, display, targetBoxShadowColor, targetColor, targetPaddingAll, gathering } from './AllProp';
import { useState } from 'react';
import styleElement from '../pages/dashboard/styleElement';
import TextEditorReact from './texteditor';


const rgbToHex = (rgb) => {
  const rgbValues = rgb.match(/\d+/g);
  if (!rgbValues) return rgb; // Return the original value if it doesn't match

  return `#${((1 << 24) + (parseInt(rgbValues[0]) << 16) + (parseInt(rgbValues[1]) << 8) + parseInt(rgbValues[2]))
    .toString(16)
    .slice(1)
    .toUpperCase()}`;
};





export default function Basic({ target }) {

  const [targ, setarg] = useState(target)
  const [object, setobject] = useState({})
  const [selectedOption, setSelectedOption] = useState('px');
  const refs = useRef([]);
  const refM = useRef([]);
  const refMove = useRef([]);
  const refB = useRef([]);
  const refsh = useRef([]);
  const width = targ.getBoundingClientRect().width;
  const height = targ.getBoundingClientRect().height;
  const [size, setSize] = useState({ x: width, y: height });
  const [update, setupdate] = useState(true)
  const [active, setActive] = useState(false);


  function handleToggle(ele) {

    setActive(!active);

    const mydsvg = ele.target.parentElement.querySelector(".rou");

    const myclassvsg = active ? "mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5 rotate-180" : "mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5"
    mydsvg.className = myclassvsg;


    const mydrgdawn = ele.target.parentElement.parentElement.querySelector(".h-sh")
    const myclass = active ? "pl-[62px] duration-200 ease-in-out h-sh block" : "pl-[62px] duration-200 ease-in-out hidden  h-sh ";
    mydrgdawn.className = myclass;



    event.preventDefault();

  };
  try {
    const divclass = document.getElementById("this").querySelector(".myborder")
    const classname = divclass.className ? divclass.className : ""
    if (classname != "") {

      divclass.classList.remove("myborder")
      targ.classList.add("myborder")
    } else {
      targ.classList.add("myborder")
      divclass.removeAttribute("myborder");

    }
  } catch (err) {

  }


  useEffect(() => {
    setSize({ x: width, y: height })
    setarg(target)
    setobject({})

    try {
      let id = targ && targ.id ? targ.id : "";

      for (let rule of styleElement.sheet.cssRules) {
        // Check for ID selector
        if (rule.selectorText === "#" + id) {
          // Append styles to the object
          setobject(prev => ({
            ...prev,
            ...Array.from(rule.style).reduce((acc, property) => {
              acc[property] = rule.style.getPropertyValue(property);
              return acc;
            }, {})
          }));
        }

        // Convert classList to an array and iterate
        Array.from(targ.classList || []).forEach(className => {
          if (rule.selectorText === "." + className && rule.selectorText !== ".div") {
            // Append styles to the object
            setobject(prev => ({
              ...prev,

              ...Array.from(rule.style).reduce((acc, property) => {
                acc[property] = rule.style.getPropertyValue(property);
                return acc;
              }, {})
            }));
          }
        });
      }

    }
    catch (err) {
      // console.log(err)
    }


  }, [target, targ.className, update])



  const handleChange = (event) => {
    if (event.target.value == '%') {
      if ((size.x <= 100 && size.y <= 100)) {
        setSelectedOption('%')

      } else {
        alert("(100>)يجب ان يكون العرض و الطول ")
      }

    } else {
      setSelectedOption("px");

    }

  };
  const refScale = useRef(null);
  const s = {
    color: "white",
  }






  return (

    <div className="col-span-12 lg:col-span-5 -scroll-me-0 "  >
      <div className="bg-white dark:bg-neutral-700 rounded-lg " >
        {/* <button onClick={()=>Reset(targ)}>click</button> */}
        <div className="p-5">
          <div className='my-4 justify-start w-full '>
            <div id='texteditor'>
              <TextEditorReact ch={targ} />
            </div>
          </div>

          <div className='my-4 justify-start w-full '>
            <form>
              <span >
                <input type="radio" id=""
                  class="me-1 mt-0.5 h-5 w-5 border border-blue-gray-200"
                  value="px"
                  checked={selectedOption === 'px'}
                  onChange={handleChange}
                />
                <label htmlFor="" className='mx-2' > px</label>
              </span>
              <span >
                <input type="radio" id=""
                  class="me-1 mt-0.5 h-5 w-5 border border-blue-gray-200"

                  value="%"
                  checked={selectedOption === '%'}
                  onChange={handleChange}
                />
                <label htmlFor="" className='mx-2' >%</label>
              </span>
            </form>
          </div>
          <div className='flex justify-evenly gap-6 border-b-2'>




            <div className="mb-6">
              <label
                className="mb-2 text-sm text-neutral-500 dark:text-neutral-200 flex justify-between"
                htmlFor="formTextSize"
              >
                <span className="font-bold">
                  عرض العنصر
                </span>
                <span className="font-bold">
                  {parseInt(size.x) + selectedOption}
                </span>
              </label>
              <input
                className="transparent h-[25px] border border-blue-gray-800 w-full cursor-pointer appearance-none rounded-sm bg-neutral-200 dark:bg-neutral-600"
                type="number"
                value={parseInt(size.x)}
                onChange={function (ele) {
                  gathering(targ, { 'width': ele.target.value + selectedOption })
                  setSize({ x: ele.target.value, y: size.y }
                  )
                }}

              />
            </div>
            <div className="mb-6">
              <label
                className="mb-2 text-sm text-neutral-500 dark:text-neutral-200 flex justify-between"
                htmlFor="formIconSize"
              >
                <span className="font-bold">
                  طول العنصر
                </span>
                <span className="font-bold">
                  {parseInt(size.y) + selectedOption}
                </span>
              </label>
              <input
                className="transparent h-[25px] border-blue-gray-800  w-full cursor-pointer appearance-none rounded-sm  bg-neutral-200 dark:bg-neutral-600"
                type="number"
                value={parseInt(size.y)}
                onChange={
                  function (ele) {
                    gathering(targ, { 'height': ele.target.value + selectedOption })
                    setSize({ y: ele.target.value, x: size.x })
                  }

                }
              />
            </div>
          </div>
          <div className='flex justify-center flex-col font-bold  border-b-2'>
            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  ازاحه العنصر
                </h4>
              </div>
            </button>
            <div
              className="pl-[62px] duration-200 ease-in-out hidden  h-sh  "
            >


              <form >
                <div className='flex items-start flex-row  '>



                  <ul className='w-full flex justify-center flex-row my-2 ul list-none'>
                    <div className='mx-1 text-right'>
                      <span >



                        <input

                          className="radio"
                          id="top"
                          name="rad"
                          value={"top"}
                          type="radio"
                          ref={(el) => refMove.current[3] = el}
                        />
                        <label htmlFor="top">

                          <div className="li">

                            <h1 className='svg  flex justify-center text-sm  '>
                              فوق

                            </h1>


                          </div>

                        </label>

                      </span>
                      <span ><p>{(targ.style["top"]) ? targ.style["top"] : ((object["top"]) ? object["top"] : "0px")} </p> </span>
                    </div>
                    <div className='mx-1 text-right'>
                      <span  >


                        <input

                          className="radio"
                          id="bottom"
                          name="rad"
                          value={"bottom"}
                          type="radio"
                          ref={(el) => refMove.current[1] = el}
                        />
                        <label htmlFor="bottom">

                          <div className="li">

                            <h1 className='svg  flex justify-center text-sm  '>
                              تحت

                            </h1>


                          </div>
                        </label>
                      </span>

                      <span  > <p>{(targ.style["bottom"]) ? targ.style["bottom"] : ((object["bottom"]) ? object["bottom"] : "0px")}  </p></span>
                    </div>

                    <div className='mx-1 text-right'>
                      <span >
                        <input

                          className="radio"
                          id="left"
                          name="rad"
                          value={"left"}
                          type="radio"
                          ref={(el) => refMove.current[2] = el}
                        />
                        <label htmlFor="left">

                          <li className="li">

                            <h1 className='svg  flex justify-center text-sm  '>

                              يسار
                            </h1>


                          </li>
                        </label>
                      </span>
                      <span >{(targ.style["left"]) ? targ.style["left"] : ((object["left"]) ? object["left"] : "0px")}  </span>

                    </div>
                    <div className='mx-1 text-right '>
                      <span >
                        <input

                          className="radio"
                          id="right"
                          name="rad"
                          value={"right"}
                          type="radio"
                          ref={(el) => refMove.current[0] = el}
                        />
                        <label htmlFor="right">

                          <li className="li">

                            <h1 className='svg  flex justify-center text-sm  '>
                              يمين

                            </h1>


                          </li>
                        </label>
                      </span>
                      <span>{(targ.style["right"]) ? targ.style["right"] : ((object["right"]) ? object["right"] : "0px")}  </span>

                    </div>
                  </ul>


                </div> </form>
              <div>


                <form class="max-w-xs mx-auto">

                  <div class="relative flex items-center max-w-[8rem]">
                    <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refMove, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                      </svg>
                    </button>
                    <input type="number" id="quantity-input" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" defaultValue={1} /><button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refMove, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                      </svg>
                    </button>
                  </div>
                </form>

              </div>    </div>
          </div>
          <div className='flex justify-center flex-col font-bold  border-b-2'>

            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  الهوامش الخارجيه
                </h4>
              </div>
            </button>
            <div
              className="pl-[62px] duration-200 ease-in-out hidden  h-sh  "
            >
              <form>
                <div className='flex items-start flex-row my-2 '>

                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                      ref={(el) => refs.current[0] = el}
                      value={"margin-right"}
                    />
                    <label htmlFor="" className='text-black'> يمين <span>{(targ.style["margin-right"]) ? targ.style["margin-right"] : ((object["margin-right"]) ? object["margin-right"] : "0px")} </span> </label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refs.current[1] = el}
                      value={"margin-bottom"}
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                    />
                    <label htmlFor="" className='text-black'> تحت  <span>{(targ.style["margin-bottom"]) ? targ.style["margin-bottom"] : ((object["margin-bottom"]) ? object["margin-bottom"] : "0px")} </span></label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refs.current[2] = el}
                      value={"margin-left"}
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                    />
                    <label htmlFor="" className='text-black'> يسار  <span>{(targ.style["margin-left"]) ? targ.style["margin-left"] : ((object["margin-left"]) ? object["margin-left"] : "0px")} </span></label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refs.current[3] = el} defaultChecked
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                      value={"margin-top"}
                    />
                    <label htmlFor="" className='text-black'> فوق  <span>{(targ.style["margin-top"]) ? targ.style["margin-top"] : ((object["margin-top"]) ? object["margin-top"] : "0px")} </span></label>
                  </span>


                </div>  </form>
              <div>


                <form class="max-w-xs mx-auto">

                  <div class="relative flex items-center max-w-[8rem]">
                    <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refs, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" fill="none" viewBox="0 0 18 2" >
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                      </svg>
                    </button>
                    <input type="number" id="quantity-input" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" defaultValue={1} required />
                    <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refs, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                      </svg>
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
          <div className='flex justify-center flex-col font-bold  border-b-2'>

            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  الهوامش الداخليه
                </h4>
              </div>
            </button>

            <div
              className="pl-[62px] duration-200 ease-in-out hidden  h-sh  "
            >
              <form>
                <div className='flex items-start flex-row my-2 '>

                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                      ref={(el) => refM.current[0] = el}
                      value={"padding-right"}
                    />
                    <label htmlFor="" className='text-black'> يمين <span>{(targ.style["padding-right"]) ? targ.style["padding-right"] : ((object["padding-right"]) ? object["padding-right"] : "0px")} </span></label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refM.current[1] = el}
                      value={"padding-bottom"}
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                    />
                    <label htmlFor="" className='text-black'> تحت <span>{(targ.style["padding-bottom"]) ? targ.style["padding-bottom"] : ((object["padding-bottom"]) ? object["padding-bottom"] : "0px")}  </span></label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refM.current[2] = el}
                      value={"padding-left"}
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                    />
                    <label htmlFor="" className='text-black'>  يسار <span>{(targ.style["padding-left"]) ? targ.style["padding-left"] : ((object["padding-left"]) ? object["padding-left"] : "0px")} </span></label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refM.current[3] = el} defaultChecked
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                      value={"padding-top"}
                    />
                    <label htmlFor="" className='text-black' >فوق <span>{(targ.style["padding-top"]) ? targ.style["padding-top"] : ((object["padding-top"]) ? object["padding-top"] : "0px")}  </span></label>
                  </span>


                </div>  </form>
              <div>
                <form class="max-w-xs mx-auto">

                  <div class="relative flex items-center max-w-[8rem]">
                    <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refM, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                      </svg>
                    </button>
                    <input type="number" id="quantity-input" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" defaultValue={1} required />    <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refM, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                      </svg>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div className='flex justify-center flex-col font-bold  border-b-2'>

            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  الحواف
                </h4>
              </div>
            </button>

            <div
              className="pl-[62px] duration-200 ease-in-out hidden  h-sh  "
            >
              <form>
                <div className='flex items-start flex-row my-2 '>

                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                      ref={(el) => refB.current[0] = el}
                      value={"border-right-width"}
                    />
                    <label htmlFor="" className='text-black'> يمين <span>{(targ.style["border-right-width"]) ? targ.style["border-right-width"] : ((object["border-right-width"]) ? object["border-right-width"] : "0px")} </span></label>

                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refB.current[1] = el}
                      value={"border-bottom-width"}
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                    />
                    <label htmlFor="" className='text-black'> تحت <span>{(targ.style["border-bottom-width"]) ? targ.style["border-bottom-width"] : ((object["border-bottom-width"]) ? object["border-bottom-width"] : "0px")} </span></label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refB.current[2] = el}
                      value={"border-left-width"}
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                    />
                    <label htmlFor="" className='text-black'>  يسار <span>{(targ.style["border-left-width"]) ? targ.style["border-left-width"] : ((object["border-left-width"]) ? object["border-left-width"] : "0px")}  </span></label>
                  </span>
                  <span className='flex justify-center'>
                    <input type="checkbox" id=""
                      ref={(el) => refB.current[3] = el} defaultChecked
                      class="me-1 mt-0.5 h-5 w-5 checked:border-2 checked:border-yellow-500 mx-1"
                      value={"border-top-width"}
                    />
                    <label htmlFor="" className='text-black' >فوق <span>{(targ.style["border-top-width"]) ? targ.style["border-top-width"] : ((object["border-top-width"]) ? object["border-top-width"] : "0px")}  </span></label>
                  </span>

                </div>
              </form>
              <div className='w-full flex flex-row '>
                <input type="color" className='h-[30px]  mx-2' name="color"
                  placeholder='ddd'
                  value={rgbToHex((targ.style["border-right-color"]) ? targ.style["border-right-color"] : (object["border-right-color"]) ? object["border-right-color"] : "rgb(255, 255, 255)")}

                  onChange={function (ele) { gathering(targ, { 'border-right-color': ele.target.value }); setupdate(update ? false : true) }}
                />
                <input type="color" className='h-[30px] mx-2' name="color"
                  placeholder='ddd'
                  value={rgbToHex((targ.style["border-bottom-color"]) ? targ.style["border-bottom-color"] : (object["border-bottom-color"]) ? object["border-bottom-color"] : "rgb(255, 255, 255)")}

                  onChange={function (ele) { gathering(targ, { 'border-bottom-color': ele.target.value }); setupdate(update ? false : true) }}
                />
                <input type="color" className='h-[30px]mx-2' name="color"
                  placeholder='ddd'
                  value={rgbToHex((targ.style["border-left-color"]) ? targ.style["border-left-color"] : (object["border-left-color"]) ? object["border-left-color"] : "rgb(255, 255, 255)")}
                  onChange={function (ele) { gathering(targ, { 'border-left-color': ele.target.value }); setupdate(update ? false : true) }}

                />
                <input type="color" className='h-[30px] mx-2' name="color"
                  placeholder='ddd'
                  value={rgbToHex((targ.style["border-top-color"]) ? targ.style["border-top-color"] : (object["border-top-color"]) ? object["border-top-color"] : "rgb(255, 255, 255)")}
                  onChange={function (ele) { gathering(targ, { 'border-top-color': ele.target.value }); setupdate(update ? false : true) }}

                />

              </div>
              <div  >
                <ul className='w-full flex flex-row my-2 ul'>
                  <li className='mx-1'>
                    <input

                      className="radio"
                      id="choose2"
                      name="rad"
                      value={"solid"}
                      type="radio"
                      defaultChecked
                      onChange={function (ele) { borderstyle(targ, ele, refB); setupdate(update ? false : true) }}
                    />
                    <label htmlFor="choose2">
                      <li className="li">

                        <h1 className='svg text-2xl'>ــــ</h1>

                      </li>
                    </label></li>
                  <li className='mx-1'>
                    <input
                      className="radio"
                      id="choose3"
                      name="rad"
                      value={"dashed"}
                      type="radio"

                      onChange={function (ele) { borderstyle(targ, ele, refB); setupdate(update ? false : true) }}
                    />
                    <label htmlFor="choose3">
                      <li className="li">

                        <h1 className='svg text-2xl'>----</h1>

                      </li>
                    </label></li>
                  <li className='mx-1'>
                    <input
                      className="radio"
                      id="choose4"
                      name="rad"
                      type="radio"
                      value={"dotted"}

                      onChange={function (ele) { borderstyle(targ, ele, refB); setupdate(update ? false : true) }}
                    />
                    <label htmlFor="choose4">
                      <li className="li">

                        <h1 className='svg text-2xl'>.....</h1>

                      </li >
                    </label></li>
                </ul>
                <input
                  className="transparent h-[4px] my-1 w-full cursor-pointer appearance-none bg-blue-gray-600 dark:bg-neutral-600"
                  id="formIconSize"

                  max="200"
                  min="0"
                  step="1"
                  type="range"

                  onChange={function (ele) { borderstyle(targ, ele, refB); setupdate(update ? false : true) }}

                />
              </div>
              <div>
                <form class="max-w-xs mx-auto my-1">

                  <div class="relative flex items-center max-w-[8rem]">

                    <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refB, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                      </svg>
                    </button>
                    <input type="number" id="quantity-input" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" defaultValue={1} required />    <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" onClick={function (ele) { targetPaddingAll(targ, ele, refB, object); setupdate(update ? false : true) }}>
                      <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                      </svg>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div className='flex justify-center flex-col font-bold  border-b-2'>

            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  تدفق العناصر
                </h4>
              </div>
            </button>

            <div
              className="pl-[62px] duration-200 ease-in-out hidden  h-sh"
              dir="rtl" id="felx">

              <div  >
                <ul className='w-full flex flex-row my-2 ul list-none'>
                  <span className='mx-1'>
                    <input

                      className="radio"
                      id="ch2"
                      name="rad"
                      value={"block"}
                      type="radio"

                      defaultChecked={(targ.style["display"] == "block") ? true : ((object["display"] == "block") ? true : false)}
                      onChange={function (ele) { display(targ, { "display": ele.target.value }); setupdate(update ? false : true) }}
                    />
                    <label htmlFor="ch2">

                      <li className="li">

                        <h1 className='svg  flex justify-center'>
                          <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style={{ width: "30px" }}>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                          </svg>


                        </h1>


                      </li>
                    </label></span>
                  <span className='mx-1'>
                    <input
                      className="radio"
                      id="ch3"
                      name="rad"
                      value={"inline-block"}
                      type="radio"
                      defaultChecked={(targ.style["display"] == "inline-block") ? true : ((object["display"] == "inline-block") ? true : false)}
                      onChange={function (ele) { display(targ, { "display": ele.target.value }); setupdate(update ? false : true) }}
                    />
                    <label htmlFor="ch3">

                      <li className="li">

                        <h1 className='svg text-2xl flex justify-center' >
                          <div className='flex justify-center' style={{ transform: "rotate(90deg)" }}>
                            <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style={{ width: "30px" }}>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                            </svg></div>
                        </h1>

                      </li>
                    </label></span>  </ul>
                <div className='m-2'>
                  <input
                    className="radio"
                    id="ch4"
                    name="rad"
                    type="radio"
                    value={"flex"}
                    defaultChecked={(targ.style["display"] == "flex") ? true : ((object["display"] == "flex") ? true : false)}
                    onChange={function (ele) { display(targ, { "display": ele.target.value }); setupdate(update ? false : true) }}
                  />
                  <label htmlFor="ch4">
                    <li className="li list-none">

                      <div className='svg text-sm font-bold'>
                        توزيع بشكل مرن
                      </div>

                    </li >
                  </label></div>
                <form>
                  <ul className='w-full flex flex-row my-2 ul list-none' >
                    <span className='mx-1'>
                      <input
                        className="radio"
                        id="ch7"
                        name="rad"
                        value={"wrap"}
                        type="radio"

                        onClick={function (ele) { display(targ, { "flex-wrap": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch7">
                        <li className="li">

                          <h1 className='svg text-2xl flex justify-center items-center'>
                            <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style={{ width: "30px" }}>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"></path>
                            </svg>
                          </h1>

                        </li>
                      </label></span>
                    <span  >
                      <input
                        className="radio"
                        id="ch13"
                        name="rad"
                        value={"nowrap"}
                        type="radio"

                        onChange={function (ele) { display(targ, { "flex-wrap": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch13">
                        <li className="li">

                          <h1 className='svg text-2xl flex justify-center items-center'>
                            <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style={{ width: "30px" }}>
                              <path stroke-linecap="round" stroke-linejoin="round" d="
  M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6Z

  M13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6Z
  M13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"></path>
                            </svg>
                          </h1>

                        </li>
                      </label></span>

                  </ul>
                </form>
                <form className='my-2'>


                  <ul className='w-full flex flex-row my-2 ul list-none'>
                    <span className='mx-1'>
                      <input
                        className="radio"
                        id="ch5"
                        name="rad"
                        value={"column"}
                        type="radio"

                        onChange={function (ele) { display(targ, { "display": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch5">
                        <li className="li">

                          <h1 className='svg text-2xl '>
                            <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style={{ width: "30px" }}>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM"></path>
                            </svg>
                          </h1>

                        </li>
                      </label></span>
                    <span className='mx-1'>
                      <input
                        className="radio"
                        id="ch6"
                        name="rad"
                        value={"row"}
                        type="radio"

                        onChange={function (ele) { display(targ, { "flex-direction": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch6">
                        <li className="li">

                          <h1 className='svg text-2xl flex justify-center items-center'>
                            <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style={{ width: "30px" }}>
                              <path stroke-linecap="round" stroke-linejoin="round" d="
                                                            M3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25Z
                                                            M13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"></path>
                            </svg>
                          </h1>

                        </li>
                      </label></span>

                  </ul>
                </form>
                <form >


                  <ul className='w-full flex flex-row my-2 ul list-none'>
                    <span className='mx-1'>
                      <input
                        className="radio"
                        id="ch11"
                        name="rad"
                        value={"end"}
                        type="radio"

                        onChange={function (ele) { display(targ, { "justify-content": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch11">
                        <li className="li">

                          <h1 className='svg text-2xl flex justify-start items-center'>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="5" y="5" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="7" y="7" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                          </h1>

                        </li>
                      </label></span>
                    <span className='mx-1'>
                      <input
                        className="radio"
                        id="ch8"
                        name="rad"
                        value={"start"}
                        type="radio"

                        onChange={function (ele) { display(targ, { "justify-content": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch8">
                        <li className="li">

                          <h1 className='svg text-2xl flex justify-end items-center '>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="5" y="5" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="7" y="7" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                          </h1>

                        </li>
                      </label></span>
                    <span className='mx-1'>
                      <input
                        className="radio"
                        id="ch9"
                        name="rad"
                        value={"center"}
                        type="radio"

                        onChange={function (ele) { display(targ, { "justify-content": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch9">
                        <li className="li">

                          <h1 className='svg text-2xl flex justify-center items-center'>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="5" y="5" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="7" y="7" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                          </h1>

                        </li>
                      </label></span>
                    <span className='mx-1'>
                      <input
                        className="radio"
                        id="ch10"
                        name="rad"
                        value={"space-between"}
                        type="radio"

                        onChange={function (ele) { display(targ, { "justify-content": ele.target.value }); setupdate(update ? false : true) }}
                      />
                      <label htmlFor="ch10">
                        <li className="li">

                          <div className='svg text-2xl flex justify-between items-center'>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="5" y="5" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                            <div>
                              <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" width="10" height="15" viewBox="0 0 100 100">
                                <rect x="7" y="7" width="90" height="90" rx="15" ry="15" fill="none" stroke="#000" stroke-width="15" />
                              </svg></div>
                          </div>

                        </li>
                      </label>
                    </span>

                  </ul>
                </form>
              </div>
              <span >
                <input
                  className="radio"
                  id="re1"
                  name="rad"
                  value={"nowrap"}
                  type="radio"

                  onChange={function (ele) { display(targ, "remove"); setupdate(update ? false : true) }}
                />
                <label htmlFor="re1">
                  <li className="li">

                    <h1 className='svg text-sm flex justify-center items-center'>
                      ازاله التغيرت
                    </h1>

                  </li>
                </label></span>

            </div>
          </div>
          <div className='flex justify-center flex-col font-bold  border-b-2'>

            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  الضل
                </h4>
              </div>
            </button>

            <div
              className="pl-[62px] duration-200 ease-in-out hidden  h-sh  "
            >
              <form >
                <div className='flex items-start flex-row  '>



                  <ul className='w-full flex justify-center flex-row my-2 ul list-none'>
                    <div className='mx-1 text-right my-4'>
                      <span >



                        <input

                          className="radio"
                          id="top1"
                          name="rad"
                          value={"top"}
                          type="radio"
                          ref={(el) => refsh.current[3] = el}
                        />
                        <label htmlFor="top1">

                          <div className="li">

                            <h1 className='svg  flex justify-center text-sm  '>
                              فوق

                            </h1>


                          </div>

                        </label>

                      </span>
                    </div>
                    <div className='mx-1 text-right mt-4'>
                      <span  >


                        <input

                          className="radio my-2"
                          id="bottom1"
                          name="rad"
                          value={"bottom"}
                          type="radio"
                          ref={(el) => refsh.current[1] = el}
                        />
                        <label htmlFor="bottom1">

                          <div className="li">

                            <h1 className='svg  flex justify-center text-sm  '>
                              تحت

                            </h1>


                          </div>
                        </label>
                      </span>

                    </div>

                    <div className='mx-1 text-right mt-4'>
                      <span >
                        <input

                          className="radio"
                          id="left1"
                          name="rad"
                          value={"left"}
                          type="radio"
                          ref={(el) => refsh.current[2] = el}
                        />
                        <label htmlFor="left1">

                          <li className="li">

                            <h1 className='svg  flex justify-center text-sm  '>

                              يسار
                            </h1>


                          </li>
                        </label>
                      </span>

                    </div>
                    <div className='mx-1 text-right mt-4 '>
                      <span >
                        <input

                          className="radio"
                          id="right1"
                          name="rad"
                          value={"right"}
                          type="radio"
                          ref={(el) => refsh.current[0] = el}
                        />
                        <label htmlFor="right1">

                          <li className="li">

                            <h1 className='svg  flex justify-center text-sm  '>
                              يمين

                            </h1>


                          </li>
                        </label>
                      </span>

                    </div>
                  </ul>


                </div> </form>
              <input type="color" className='h-[30px] mx-2' name="color"
                id='color'

                placeholder='ddd'
                onChange={function (ele) {

                  targetBoxShadowColor(targ, ele, refsh); setupdate(update ? false : true)
                }}
              />


              <div  >

                <input
                  className="transparent h-[4px] my-4 w-full cursor-pointer appearance-none bg-blue-gray-600 dark:bg-neutral-600"

                  ref={(el) => refsh.current[4] = el}
                  max="50"
                  min="0"
                  step="-50"
                  type="range"

                  onChange={function () { targetBoxShadowColor(targ, refsh); setupdate(update ? false : true) }}

                />
              </div>
              <div  >

                <input
                  className="transparent h-[4px] my-4 w-full cursor-pointer appearance-none bg-blue-gray-600 dark:bg-neutral-600"

                  ref={(el) => refsh.current[5] = el}
                  max="50"
                  min="0"
                  step="-50"
                  type="range"

                  onChange={function () { targetBoxShadowColor(targ, refsh); setupdate(update ? false : true) }}

                />
              </div>
              <div  >

                <input
                  className="transparent h-[4px] my-4 w-full cursor-pointer appearance-none bg-blue-gray-600 dark:bg-neutral-600"

                  ref={(el) => refsh.current[6] = el}
                  max="50"
                  min="0"
                  step="-50"
                  type="range"

                  onChange={function () { targetBoxShadowColor(targ, refsh); setupdate(update ? false : true) }}

                />
              </div>

            </div>
          </div>
          <div className='flex justify-center flex-col font-bold  border-b-2'>

            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  لون الخلفيه
                </h4>
              </div>
            </button>

            <div
              className="pl-[62px] duration-200 ease-in-out  hidden  h-sh  "
            >
              <div className="flex flex-row justify-between w-full">
                <input type="color" id="color" name="color"
                  value={rgbToHex((targ.style["background-color"]) ? targ.style["background-color"] : (object["background-color"]) ? object["background-color"] : "rgb(255, 255, 255)")}
                  onChange={function (ele) { gathering(targ, { 'background-color': ele.target.value }); setupdate(update ? false : true) }}

                />
                <div class="info">
                  {rgbToHex((targ.style["background-color"]) ? targ.style["background-color"] : (object["background-color"]) ? object["background-color"] : "rgb(255, 255, 255)")}

                </div></div>
            </div>

          </div >
          <div className='flex justify-center flex-col font-bold  border-b-2'>

            <button
              className={`faq-btn flex w-full text-left`}
              onClick={(ele) => handleToggle(ele)}
            >
              <div className="mr-5 flex h-10 w-full max-w-[40px] rou items-center justify-center rounded-lg bg-primary/5 text-primary dark:bg-white/5">
                <svg
                  className="fill-primary stroke-primary duration-200 ease-in-out"
                  width="17"
                  height="10"
                  viewBox="0 0 17 10"
                >
                  <path
                    d="M7.28687 8.43257L7.28679 8.43265L7.29496 8.43985C7.62576 8.73124 8.02464 8.86001 8.41472 8.86001C8.83092 8.86001 9.22376 8.69083 9.53447 8.41713L9.53454 8.41721L9.54184 8.41052L15.7631 2.70784L15.7691 2.70231L15.7749 2.69659C16.0981 2.38028 16.1985 1.80579 15.7981 1.41393C15.4803 1.1028 14.9167 1.00854 14.5249 1.38489L8.41472 7.00806L2.29995 1.38063L2.29151 1.37286L2.28271 1.36548C1.93092 1.07036 1.38469 1.06804 1.03129 1.41393L1.01755 1.42738L1.00488 1.44184C0.69687 1.79355 0.695778 2.34549 1.0545 2.69659L1.05999 2.70196L1.06565 2.70717L7.28687 8.43257Z"
                    fill=""
                    stroke=""
                  />
                </svg>
              </div>

              <div className="w-full">
                <h4 className="mt-1 text-lg font-semibold text-dark dark:text-white text-right">
                  درجه الاضائة                    </h4>
              </div>
            </button>

            <div
              className="pl-[62px] duration-200 ease-in-out  hidden  h-sh  "
            >
              <input
                className="transparent h-[4px] my-1 w-full cursor-pointer appearance-none bg-blue-gray-600 dark:bg-neutral-600"
                id="formIconSize"

                max="1"
                min="0"
                step="0.1"
                type="range"

                onChange={function (ele) { gathering(targ, { opacity: `${ele.target.value}` }); setupdate(update ? false : true) }}

              />
              <span>{(targ.style["opacity"]) ? targ.style["opacity"] : ((object["opacity"]) ? object["opacity"] : "1")} </span>

            </div>

          </div >


        </div>






      </div>
    </div>

  )
}
