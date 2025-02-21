import React, { useEffect } from 'react';
import './StepProgress.css';
import './step';
export default function StepProgress() {
    return (
        <div className='step-body'>
            <div className="progress-steps">
                <div className="top">
                    <div className="progress">
                        <span></span>
                    </div>
                    <div className="steps">
                        <div
                            className="step active"
                            data-step="1"
                        >
                            <span>
                                1
                            </span>
                        </div>
                        <div
                            className="step"
                            data-step="2"
                        >
                            <span>
                                2
                            </span>
                        </div>
                        <div
                            className="step"
                            data-step="3"
                        >
                            <span>
                                3
                            </span>
                        </div>
                        <div
                            className="step"
                            data-step="4"
                        >
                            <span>
                                4
                            </span>
                        </div>
                    </div>
                </div>
                {/* <div className="buttons">
                    <button
                        className="btn btn-prev disabled"
                        disabled
                    >
                        السابق
                    </button>
                    <button className="btn btn-next"
                    >
                        التالي
                    </button>
                </div> */}
            </div>
        </div>
    )
}