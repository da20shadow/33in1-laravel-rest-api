import {BsCheckLg} from "react-icons/bs";

function Alert({isError = false,message}){

    const style = `centered z-50 flex gap-1 w-11/12 mx-auto px-2 py-3 text-center font-bold border rounded-lg
    ${isError ? 'bg-rose-50 text-rose-900 border-rose-900' : 'bg-green-50 text-green-900 border-green-900'}`

    return (
        <div className={style}>
            {isError ?' ⛔' : '✔️'}
            {message}

        </div>
    );
}
export default Alert;
