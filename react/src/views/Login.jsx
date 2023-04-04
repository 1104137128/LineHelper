import { useRef, useState, useEffect } from "react";
import axiosClient from "../axios-client";
import { useStateContext } from "../contexts/ContextProvider";

export default function Login() {
    const emailRef = useRef();
    const passwordRef = useRef();
    const [errors, setErrors] = useState(null);
    const { setUser, setToken } = useStateContext();

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

    useEffect(() => {
        // 載入 Facebook SDK
        (function (d, s, id) {
            var js,
                fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js';
            fjs.parentNode.insertBefore(js, fjs);
        })(document, 'script', 'facebook-jssdk');

        // SDK 載入完成時會立即呼叫 fbAsyncInit，在這個函式中對 Facebook SDK 進行初始化
        window.fbAsyncInit = function () {
            // 初始化 Facebook SDK
            window.FB.init({
                appId: '6008707099213591',
                cookie: true,
                xfbml: true,
                version: 'v16.0'
            });

            // 取得使用者登入狀態
            window.FB.getLoginStatus(function (response) {
                console.log('[refreshLoginStatus]', response);
            });

            console.log('[fbAsyncInit] after window.FB.init');
            window.FB.AppEvents.logPageView();
        };
    }, []);

    const LoginFB = () => {
        // 跳出 Facebook 登入的對話框
        window.FB.login(function (response) {
            if (response.status == 'connected') {
                window.FB.api('/me', 'GET', { fields: 'name,email' }, function (res) {
                    axiosClient.post('/login_fb', { email: res.email, name: res.name }).then(res => {
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
                });
            }
        }, { scope: 'public_profile, email' });
    };

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

                <br></br>

                <button className="btn btn-block" style={{background: 'cornflowerblue'}} onClick={LoginFB}>Facebook Login</button>
            </div>
        </div>
    )
}
