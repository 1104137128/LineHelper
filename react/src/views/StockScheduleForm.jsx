import { useEffect, useState } from "react"
import { useNavigate, useParams } from "react-router-dom"
import axiosClient from "../axios-client"

export default function StockScheduleForm() {
    const {id} = useParams()
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false)
    const [stock, setStock] = useState({id: null, name: ''})

    if (id) {
        useEffect(() => {
            setLoading(true)
            axiosClient.get(`/stock/${id}`).then(res => {
                setLoading(false)
                setStock(res.data[0])
            })
        }, [])
    }

    const onSubmit = (ev) => {
        ev.preventDefault();

        if (stock.id) {
            axiosClient.put(`/stock/${stock.id}`, stock).then(() => {
                navigate('/stock')
            })
        } else {
            axiosClient.post('/stock', stock).then(() => {
                navigate('/stock')
            })
        }
    }

    return (
        <div>
            {stock.id && <h1>Update 股票排程: {stock.name}</h1>}
            {!stock.id && <h1>Create 股票排程</h1>}

            <div className="card animated fadeInDown">
                {loading && (
                    <div className="text-center">載入中...</div>
                )}
                {!loading &&
                    <form onSubmit={onSubmit}>
                        <input value={stock.name} onChange={ev => setStock({...stock, name: ev.target.value})} placeholder="股票代碼" />

                        <button className="btn">保存</button>
                    </form>
                }
            </div>
        </div>
    )
}
