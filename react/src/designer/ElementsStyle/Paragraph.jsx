import React from 'react'
import './Paragraph.css'
import { changeBIU, changeColorText, changeInner, changeOnClickButton, gathering, getSelected, getTarget } from './AllProp'
import Basic from './Basic';
export default function Paragraph({ change }) {
    change.onmouseover = getTarget(change);
    //change.target.addEventListener('mouseover', getTarget);
    change.target.addEventListener('mouseup', getSelected);
  return (
      <div className="col-span-12 lg:col-span-5">
          <div className="bg-white dark:bg-neutral-700 rounded-lg">
              <div className="p-5 border-b-2 border-neutral-100 dark:border-neutral-500 flex justify-between items-center">
                  <h5 className="uppercase text-sm font-bold text-neutral-500 dark:text-neutral-100">
                      الخصائص
                  </h5>
                  <button
                      className="inline-block rounded bg-white px-5 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200 relative overflow-hidden align-bottom"
                      data-te-ripple-color="primary"
                      data-te-ripple-init="true"
                      type="button"
                  >
                      إعادة تعيين
                  </button>
              </div>
          </div>
          <Basic change={change}/>
          <div className="p-6">
              <div className="button-options">
                  <div className="content">
                      <input
                          hidden
                          id="boldInput"
                          name="boldInput"
                          type="button"
                          onClick={()=>changeBIU(change,'b')}
                      />
                      <label
                          className="label-layout"
                          htmlFor="boldInput"
                      >
                          <b>
                              B
                          </b>
                      </label>
                      <input
                          hidden
                          id="italicInput"
                          name="italicInput"
                          type="button"
                          onClick={() => changeBIU(change, 'i')}
                      />
                      <label
                          className="label-layout"
                          htmlFor="italicInput"
                      >
                          <i>
                              i
                          </i>
                      </label>
                      <input
                          hidden
                          id="underlineInput"
                          name="underlineInput"
                          type="button"
                          onClick={() => changeBIU(change, 'u')}
                      />
                      <label
                          className="label-layout"
                          htmlFor="underlineInput"
                      >
                          <u>
                              U
                          </u>
                      </label>
                  </div>
              </div>
          </div>
          <div className="p-5">
              <label
                  className="mb-2 text-sm text-neutral-500 dark:text-neutral-200 flex justify-between"
                  htmlFor="formTextSize"
              >
                  <span className="font-bold">
                     حجم الخط
                  </span>
                  <span className="font-bold">
                      55px
                  </span>
              </label>
              <input
                  className="transparent h-[25px] outline-none w-full cursor-pointer appearance-none border-transparent bg-neutral-200 dark:bg-neutral-600"
                  type="number"
                  onChange={(ele) => gathering(change, ele, 'font-size')}
              />
          </div>
          <div className="p-5 body">
                <div id="swatch">
                    <input type="color" id="color" name="color"
                        onChange={(ele) => changeColorText(change,ele)}
                    />
                    <div class="info">
                        <h1>لون النص المحدد</h1>
                    </div>
                </div>
          </div>
          <div className="p-5">
              <div>
                  <label
                      className="block text-zinc-50 font-semibold text-xl"
                      htmlFor="inputname"
                  >
                    نص الفقره
                  </label>
                  <div className="mt-2">
                      <input
                          className="block bg-white w-full focus:text-orange-400  rounded-md py-1.5 px-2 border-stone-50 border-2 focus:outline-none focus:border-lime-300"
                          name="inputname"
                          type="text"
                          onChange={(ele) => changeInner(change, ele, 'innerHTML')}
                      />
                  </div>
              </div>
          </div>
          <div className="p-5">
              <div>
                  <label
                      className="block text-zinc-50 font-semibold text-xl"
                      htmlFor="inputname"
                  >
                      إضافة رابط
                  </label>
                  <div className="mt-2">
                      <input
                          className="block w-full rounded-md py-1.5 px-2 bg-white focus:text-orange-400 border-stone-50 border-2 focus:outline-none focus:border-lime-300"
                          name="inputname"
                          type="text"
                          onBlur={(ele) => changeOnClickButton(change, ele, 'click')}
                      />
                  </div>
              </div>
          </div>
        </div>
  )
}
