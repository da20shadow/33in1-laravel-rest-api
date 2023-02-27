import {useState} from "react";

const useLocalStorage = (key, initialValue) => {
    const [state, setState] = useState(() => {
        try {
            let user = localStorage.getItem(key);
            return user ? JSON.parse(user) : initialValue;
        } catch (err) {
            return initialValue;
        }
    });

    const setItem = (value) => {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            setState(value);
        }catch (err){
            console.log('Error: ',err);
        }
    }
    return [state, setItem];
}

export default useLocalStorage;
