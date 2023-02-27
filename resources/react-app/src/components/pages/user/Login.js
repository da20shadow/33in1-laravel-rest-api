import {useNavigate} from "react-router-dom";
import {authService} from "../../../services";
import {useState} from "react";
import tailwindClasses from "../../../constants/tailwindClasses";
import {useStateContext} from "../../../context/ContextProvider";

function Login() {
    const {loginUser} = useStateContext();
    const [response,setResponse] = useState('');
    const inputStyle = 'w-full p-2 mb-3 rounded bg-[#c6c6c6]';
    const redirect = useNavigate();
    const processLogin = (e) => {
        e.preventDefault();
        const logData = new FormData(e.currentTarget);
        const {email, password} = Object.fromEntries(logData);
        authService.login({email,password})
            .then(r => {
                console.log(r)
                loginUser(r.token)
                setResponse(r.message);
                setTimeout(()=>{
                    redirect('/dashboard');
                },2500)
            }).catch(err => {
            setResponse(err.message);
        })
    }

    return (
        <>
            <h1 className={'text-center text-3xl mt-5'}>Влизане</h1>

            {response ? <p className={'w-11/12 mx-auto py-2 bg-rose-50 text-center font-bold text-rose-900'}>{response}</p> : ''}

            <form onSubmit={processLogin} method={'POST'} className={'my-8 w-11/12 md:w-1/2 mx-auto shadow rounded'}>
                <input className={inputStyle} name={'email'} type="email" placeholder={'johndoe@email.com'} required/>
                <input className={inputStyle} name={'password'} type="password" placeholder={'******'} required/>
                <button className={tailwindClasses.btnFullLg} type={'submit'}>Влизане</button>
            </form>
        </>
    )
}

export default Login;
