import { useRef, useState } from "react";
import axiosClient from "../axios-client";
import { useStateContext } from "../contexts/ContextProvider";

export default function Login() {
    const emailRef = useRef();
    const passwordRef = useRef();
    const [errors, setErrors] = useState(null);
    const {setUser, setToken} = useStateContext();

    const onSubmit = (ev) => {
        ev.preventDefault();

        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value
        }

        // 登入API
        axiosClient.post('/login', payload).then(res => {
            // 設置使用者資訊&Token
            setUser(res.data.user);
            setToken(res.data.token);
        }).catch(err => {
            // 設置錯誤訊息
            const res = err.response;
            if (res && res.status === 422) {
                setErrors(res.data);
            }
        })
    }

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form onSubmit={onSubmit}>
                    <h1 className="title">Login into your account</h1>

                    {
                        // 錯誤訊息
                        errors && <div className="alert">
                            {Object.keys(errors).map(key => (
                                <p key={key}>{errors[key][0]}</p>
                            ))}
                        </div>
                    }

                    <input ref={emailRef} type="email" placeholder="Email" />
                    <input ref={passwordRef} type="password" placeholder="Password" />

                    <button className="btn btn-block">Login</button>
                </form>
            </div>
        </div>
    )
}
