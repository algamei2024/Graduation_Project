import React from 'react'
import { changeInner } from './AllProp'
import Basic from './Basic'

export default function Img({ change }) {
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
                <Basic change={change} />
                <div className="p-5">
                    <div>
                        <label
                            className="block text-zinc-50 font-semibold text-xl"
                            htmlFor="inputname"
                        >
                            إضافة صوره من رابط
                        </label>
                        <div className="mt-2">
                            <input
                                className="block bg-transparent w-full rounded-md py-1.5 px-2 focus:text-white border-stone-50 border-2 focus:outline-none focus:border-lime-300"
                                name="inputname"
                                type="text"
                                onBlur={(ele) => changeInner(change, ele, 'src')}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
