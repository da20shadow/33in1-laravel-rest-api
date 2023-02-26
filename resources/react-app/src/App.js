import {
    Header,
    Home,
    Dashboard,
    Login,
    Register,
    BodyComposition,
    AddBodyComposition,
    EditBodyComposition
} from "./components";
import {Routes,Route,Navigate} from "react-router-dom";
import {useEffect, useState} from "react";
import {authService} from "./services";

function App() {
    const [isLogged,setIsLogged] = useState(false);
    useEffect(() => {
        setIsLogged(authService.isLogged());
        console.log('isLogged', isLogged)
    },[])
    return (
        <>
            <Header isLogged={isLogged} />

            <Routes>
                <Route path={'/'} element={<Home/>} />
                <Route path={'/login'} element={isLogged ? <Navigate to="/dashboard" replace={true} /> : <Login/>} />
                <Route path={'/register'} element={isLogged ? <Navigate to="/dashboard" replace={true} /> : <Register/>} />
                <Route path={'/dashboard'} element={isLogged ?  <Dashboard/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition'} element={isLogged ?  <BodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition/add'} element={isLogged ?  <AddBodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition/edit'} element={isLogged ?  <EditBodyComposition/> : <Navigate to="/login" replace={true} />} />
            </Routes>

        </>
    );
}

export default App;
