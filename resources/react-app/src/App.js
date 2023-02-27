import {
    Header,
    Home,
    Dashboard,
    Login,
    Register,
    BodyComposition,
    AddBodyComposition,
    EditBodyComposition, Water, WaterStat, Sleep, Food, Work, Workout, NotFound
} from "./components";
import {Routes,Route,Navigate} from "react-router-dom";
import {useEffect, useState} from "react";
import {authService, userService} from "./services";
import {useStateContext} from "./context/ContextProvider";

function App() {
    const {user,isLogged,loginUser,logoutUser} = useStateContext();
    useEffect(() => {
        console.log('App.js useEffect ContextProvider user',user)
        let localStoreUser = localStorage.getItem('user');
        console.log('App.js useEffect localStore user ', localStoreUser)
        if (!isLogged || !localStoreUser) {
            console.log('There is no info in the Context!')
            console.log('Checking with request to the server...!')
            userService.get().then(r => {
                loginUser(r.token)
                console.log(r)
            }).catch(err => {
                console.log('Error: ', err)
                console.log('Error: ', err.message)
                if (err.message === 'Unauthenticated.') {
                    logoutUser()
                }
            });
        }
    },[])
    return (
        <>
            <Header />

            <Routes>
                <Route path={'/'} element={<Home/>} />
                <Route path={'/login'} element={isLogged ? <Navigate to="/dashboard" replace={true} /> : <Login/>} />
                <Route path={'/register'} element={isLogged ? <Navigate to="/dashboard" replace={true} /> : <Register/>} />
                <Route path={'/dashboard'} element={isLogged ?  <Dashboard/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition'} element={isLogged ?  <BodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition/add'} element={isLogged ?  <AddBodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition/edit'} element={isLogged ?  <EditBodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/sleep'} element={isLogged ?  <Sleep/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/water/add'} element={isLogged ?  <Water/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/water/stat'} element={isLogged ?  <WaterStat/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/food'} element={isLogged ?  <Food/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/work'} element={isLogged ?  <Work/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/workout'} element={isLogged ?  <Workout/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/*'} element={<NotFound/> } />
            </Routes>

        </>
    );
}

export default App;
