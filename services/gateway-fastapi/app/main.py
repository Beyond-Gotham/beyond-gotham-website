from fastapi import FastAPI

app = FastAPI(title="BG Gateway (placeholder)")

@app.get("/api/healthz")
def healthz():
    return {"status": "ok"}
