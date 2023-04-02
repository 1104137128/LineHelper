import { useEffect, useState } from "react"
import { useNavigate, useParams } from "react-router-dom"
import axiosClient from "../axios-client"

export default function PttScheduleForm() {
    const {id} = useParams()
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false)
    const [ptt, setPtt] = useState({
        id: null,
        name: '',
        schedule_time: ''
    })

    if (id) {
        useEffect(() => {
            setLoading(true)
            axiosClient.get(`/ptt/${id}`).then(res => {
                setLoading(false)
                setPtt(res.data[0])
            })
        }, [])
    }

    const onSubmit = (ev) => {
        ev.preventDefault();

        if (ptt.id) {
            axiosClient.put(`/ptt/${ptt.id}`, ptt).then(() => {
                navigate('/ptt')
            })
        } else {
            axiosClient.post('/ptt', ptt).then(() => {
                navigate('/ptt')
            })
        }
    }

    return (
        <div>
            {ptt.id && <h1>Update Ptt排程: {ptt.name}</h1>}
            {!ptt.id && <h1>Create Ptt排程</h1>}

            <div className="card animated fadeInDown">
                {loading && (
                    <div className="text-center">載入中...</div>
                )}
                {!loading &&
                    <form onSubmit={onSubmit}>
                        <input value={ptt.name} onChange={ev => setPtt({...ptt, name: ev.target.value})} placeholder="看板名稱" />
                        <input value={ptt.schedule_time} onChange={ev => setPtt({...ptt, schedule_time: ev.target.value})} placeholder="多久跑一次" />

                        <button className="btn">保存</button>
                    </form>
                }
            </div>
        </div>
    )
}
