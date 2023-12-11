import { useEffect, useState } from 'react'
import './App.css'
import client from './api/client.ts';

function App() {
  const [count, setCount] = useState(0)

  const ping_pong = async () => {
    const res = await client.post("/ping");
    console.log(res);
  }

  useEffect(() => {
    ping_pong()
  }, [])

  return (
    <>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => setCount((count) => count + 1)}>
          count is {count}
        </button>
        <p>
          Edit <code>src/App.tsx</code> and save to test HMR
        </p>
      </div>
      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
    </>
  )
}

export default App
