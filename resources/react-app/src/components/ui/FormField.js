import {useState} from "react";
import PropTypes from "prop-types";

function FormField(
    {
        defaultValue = '',
        label = '',
        inputType = 'text',
        inputName = '',
        step = '',
        isRequired = false
    }
) {
    const [pattern, setPattern] = useState({required: false, regex: ''});
    const [inputStyle, setInputStyle] = useState('w-full px-2 py-1 bg-gray-100 focus:bg-cyan-50 border');

    const validStyle = 'text-green-900 bg-green-100 focus:bg-green-50 border-green-700';
    const invalidStyle = 'text-rose-900 bg-rose-100 focus:bg-cyan-50 border-rose-700';

    const validateInput = (e) => {
        if (inputType === 'email') {
            setPattern({
                required: true,
                regex: "pattern='^[a-z]+[a-z0-9_]+[@gmail.com]$'"
            });
            if (!e.currentTarget.value.test(pattern.regex)) {
                return setInputStyle(invalidStyle);
            }
        }
        return setInputStyle(validStyle);
    }

    return (
        <div className="mb-3">
            <label>{label}</label>
            <input onChange={validateInput}
                   className={inputStyle}
                   name={inputName}
                   type={inputType}
                   defaultValue={defaultValue}
                   required={isRequired}/>
        </div>
    );
}

FormField.propTypes = {
    inputName: PropTypes.string.isRequired,
    inputType: PropTypes.string,
    isRequired: PropTypes.bool,
    label: PropTypes.string,
};
export default FormField;
