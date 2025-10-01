import time
from machine import Pin, ADC
import dht
import urequests
import ujson
import gc

# Configuração dos sensores
luminosity_sensor = ADC(Pin(32))
rain_sensor = ADC(Pin(35))
dht_sensor = dht.DHT11(Pin(16))

# Configuração única dos ADCs
luminosity_sensor.atten(ADC.ATTN_6DB)
rain_sensor.atten(ADC.ATTN_6DB)

url = "http://192.168.0.107:8000/api/sensor-data"  # URL da sua API

def read_sensors():
    try:
        luminosity_value = luminosity_sensor.read()
        rain_value = rain_sensor.read()

        # Converte para porcentagem e mm
        luminosity_percentage = round(max(0, (1 - (luminosity_value / 4095)) * 100), 2)
        rain_mm = round((rain_value / 4095) * 50, 2)

        dht_sensor.measure()
        temperature = round(dht_sensor.temperature(), 1)
        humidity = round(dht_sensor.humidity(), 1)

        return luminosity_percentage, rain_mm, temperature, humidity

    except Exception as e:
        print("Erro na leitura dos sensores:", e)
        return None, None, None, None


def send_data():
    luminosity, rain, temperature, humidity = read_sensors()
    if luminosity is None:
        return  # Não envia se falhar na leitura

    data = {
        "luminosity": luminosity,
        "rain": rain,
        "temperature": temperature,
        "humidity": humidity
    }

    try:
        json_data = ujson.dumps(data)
        headers = {"Content-Type": "application/json"}
        gc.collect()

        response = urequests.post(url, data=json_data, headers=headers)
        print("Servidor respondeu:", response.text)

        response.close()
        gc.collect()
    except Exception as e:
        print("Erro ao enviar dados:", e)
        gc.collect()


# Loop principal - envia a cada 10s
while True:
    send_data()
    time.sleep(10)
    gc.collect()
