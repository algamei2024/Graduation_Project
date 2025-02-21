import React from 'react';
import StepProgress from './StepProgress';
import './Main.css';
import { Outlet } from 'react-router-dom';
export default function Main() {
    return (
        <div className='Main'>
            <StepProgress />
            <Outlet />
        </div>
    )
}
