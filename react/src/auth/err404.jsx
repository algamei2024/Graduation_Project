import { Link } from 'react-router-dom';
import './err404.css';
export default function Err404() {
    return (
        <>
            <div>
                <div class="error">404</div>
                <br /><br />

                <span class="info">File not found</span>
                <Link to='/dashboard' style={{ textDecoration: 'none' }} >
                    go to home
                </Link>
            </div>

            {/* <img src="http://images2.layoutsparks.com/1/160030/too-much-tv-static.gif" class="static" /> */}
        </>
    );
}