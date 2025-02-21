import React, { useRef } from 'react'
import { addItem, changeColor, getList } from './AllProp'
import Basic from './Basic';
export default function Lists({ change }) {
    const edList = useRef(null);
    change.onclick = getList(change,edList);
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
            <Basic change={change} />
            <div className="p-6">
                <div className="mb-6 body">
                    <div id="swatch">
                        <input type="color" id="color" name="color"
                            onChange={(ele) => changeColor(change, ele, 'color')}
                        />
                        <div class="info">
                            <h1>لون الخلفيه</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div ref={edList} className="p-6">
                <select onChange={(ele) => changeColor(change, ele,'list-style-type')} id='list' name='list' className='w-full p-2 rounded-sm checked:rounded-xl focus:rounded-sm'>
                    <option value="none"> لا شيء </option>
                    <option value="decimal"> ارقام</option>
                    <option value="disc"> نقاط</option>
                    <option value="square">مربع</option>
                    <option value="circle"> دائرة</option>
                    <option value="upper-alpha"> حروف كبيرة</option>
                    <option value="lower-alpha"> حروف صغيرة</option>
                    <option value="lower-roman"> حروف رومانية</option>
                </select>
            </div>
            <div className="p-6">
                <button onClick={()=>addItem(change,edList)} className='bg-white p-1 rounded-md'>إضافة عنصر في القائمة</button>
            </div>
        </div>
    )
}



