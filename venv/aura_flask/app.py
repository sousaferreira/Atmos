import os
import requests
from flask import Flask, request, jsonify
from dotenv import load_dotenv

load_dotenv()

app = Flask(__name__)

QWEN_API_KEY = os.getenv("QWEN_API_KEY")
QWEN_API_URL = "https://openrouter.ai/api/v1/chat/completions"

def get_qwen_response(prompt):
    headers = {
        "Authorization": f"Bearer {QWEN_API_KEY}",
        "Content-Type": "application/json"
    }
    data = {
        "model": "qwen3-235B-A22B-Instruct-2507",
        "messages": [{"role": "user", "content": prompt}],
        "temperature": 0.7,
        "max_tokens": 150
    }
    response = requests.post(QWEN_API_URL, json=data, headers=headers)
    if response.status_code == 200:
        return response.json()['choices'][0]['message']['content']
    else:
        return "Desculpe, não consegui processar sua solicitação no momento."

@app.route("/chat", methods=["POST"])
def chat():
    user_input = request.json.get("prompt")
    if not user_input:
        return jsonify({"error": "Prompt é obrigatório"}), 400
    response = get_qwen_response(user_input)
    return jsonify({"response": response})

if __name__ == "__main__":
    app.run(debug=True, port=5000)
