import {useNavigate, useParams} from "react-router-dom";
import {authService} from "../../../services";
import {useState} from "react";
import tailwindClasses from "../../../constants/tailwindClasses";

function Register() {

    const [response,setResponse] = useState('');
    const inputStyle = 'w-full p-2 mb-3 rounded bg-[#c6c6c6]';
    const redirect = useNavigate();
    const processRegistration = (e) => {
        e.preventDefault();
        const regData = new FormData(e.currentTarget);
        const {email, password, confirmPassword} = Object.fromEntries(regData);

        authService.register({email,password, password_confirmation: confirmPassword})
            .then(r => {
                console.log(r)
                setResponse(r.message);
                redirect('/login');
            }).catch(err => {
            setResponse(err.message);
        })
    }

    return (
        <>
            <h1 className={'text-center text-3xl mt-5'}>Регистрация</h1>

            {response ? <p className={'w-11/12 mx-auto py-2 bg-rose-50 text-center font-bold text-rose-900'}>{response}</p> : ''}

            <form onSubmit={processRegistration} method={'POST'} className={'my-8 w-11/12 md:w-1/2 mx-auto shadow rounded'}>
                <input className={inputStyle} name={'email'} type="email" placeholder={'johndoe@email.com'} required/>
                <input className={inputStyle} name={'password'} type="password" placeholder={'******'} required/>
                <input className={inputStyle} name={'confirmPassword'} type="password" placeholder={'******'} required/>
                <button className={tailwindClasses.btnFullLg} type={'submit'}>Регистрация</button>
            </form>
        </>
    )
}

export default Register;
