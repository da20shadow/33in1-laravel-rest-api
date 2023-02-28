function FormLayout(
    {
        onSubmitHandler,
        children
    }
) {

    return (
        <form onSubmit={onSubmitHandler}>
            {children}
        </form>
    );
}
export default FormLayout;
