import {waterService} from "../../services";

function Home() {

    const getDta = (e) => {
        e.preventDefault();
        waterService.getAllTestOne().then(r => {
            console.log(r)
        }).catch(err => {
            console.log(err)
        })

    }

    return (
        <>
            <h1>Home page</h1>
            <p>Something here..</p>
            <form onSubmit={getDta}>
                <button type={'submit'}>Get Data</button>
            </form>
        </>
    )
}

export default Home;
