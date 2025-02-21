import './err403.css';
import { Link } from 'react-router-dom';

export default function Err403() {
    return (
        <div className='errFather'>
            <div class="containerErr">
                <h1>403 Forbidden</h1>
                <p>You do not have permission to access this page.</p>
                <p><Link to="/" >
                    go to home page
                </Link></p>
            </div>
        </div>

    );
}