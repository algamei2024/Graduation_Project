import { createContext, useState } from "react"

export const storeInfo = createContext({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    nameStore: '',
    logo: '',
    description: '',
    mobile: '',
    location_sotre: '',
    address_store: '',
    num_struct: ''
});

export default function StoreInformation({ children }) {
    const [info, setInfo] = useState({});

    return <storeInfo.Provider value={{ info, setInfo }} >{children}</storeInfo.Provider>;
}

