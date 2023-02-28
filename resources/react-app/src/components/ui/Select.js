function Select(
    {
        defaultValue = '',
        options = {value: '', name: ''},
        label = '',
        name = '',
        isRequired = false,
        onChange
    }
) {
    const style = `w-full text-center px-2 py-1 mb-3 shadow-sm border`;
    return (
        <>
            {label ? (<label>{label}</label>) : '' }
            <select className={style}
                    onChange={onChange}
                    name={name}
                    required={isRequired}
                    defaultValue={defaultValue}>
                {options.map(o => <option key={o.value} value={o.value}>{o.name}</option>)}
            </select>
        </>
    );
}

export default Select
