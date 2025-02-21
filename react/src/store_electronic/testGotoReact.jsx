// import axios from "axios";
import { useEffect, useState } from "react";
function TestGotoReact() {
    const [data, setData] = useState('');
    // const cookie = new Cookie();
    // const token = cookie.get('Bearer');

    useEffect(() => {
        const params = new URLSearchParams(window.location.search);
        const dataFromUrl = params.get('data');
        if (dataFromUrl) {
            setData(JSON.parse(dataFromUrl)); // تحويل البيانات من JSON إلى كائن
        }

    }, []);


    return (
        <div>
            <h1>البيانات المستلمة من Laravel</h1>
            {data ? (
                <div>
                    <h2>اسم المتجر: {data.nameStore}</h2>
                    <h3>HTML</h3>
                    <div dangerouslySetInnerHTML={{ __html: data.html }} />
                    <h3>CSS</h3>
                    <style>
                        {data.css}
                    </style>
                </div>
            ) : (
                <p>لا توجد بيانات.</p>
            )}
        </div>
    );
}

export default TestGotoReact;