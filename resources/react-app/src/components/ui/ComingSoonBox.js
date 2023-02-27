function ComingSoonBox({message = '',emoji = ''}){

    return (
        <div className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow'}>
            <h1 className={'text-gray-300 text-center font-semibold text-2xl'}>Очаквайте скоро...</h1>
            <h3 className={'text-green-200 text-center font-semibold text-lg'}>В процесс на разработка ⚙️!</h3>
            {emoji ? <p className="mt-5 text-center text-5xl">{emoji}</p> : ''}
            <p className={'mt-5 text-gray-300 text-center'}>{message}</p>
        </div>
    )
}
export default ComingSoonBox;
