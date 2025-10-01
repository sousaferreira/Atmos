import network
import time


SSID = 'Sem internet'
PASSWORD = '27041982'

def connect_wifi():
    wlan = network.WLAN(network.STA_IF)
    wlan.active(True)
    if not wlan.isconnected():
        print("Conectando ao Wi-Fi...")
        wlan.connect(SSID, PASSWORD)
        while not wlan.isconnected():
            time.sleep(1)
    print("Wi-Fi conectado:", wlan.ifconfig())
    return wlan

# Faz a conexão Wi-Fi no boot
wlan = connect_wifi()
