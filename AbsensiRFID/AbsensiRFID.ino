#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>

const char* ssid = "_upii";
const char* password = "namasayaupii";

const char* host = "192.168.43.62";

#define LED_PIN 15
#define BTN_PIN 5

void setup() {
   Serial.begin(9600);

  //setting koneksi wifi
  WiFi.hostname("NodeMCU");
  WiFi.begin(ssid, password);

  //cek koneksi wifi
  while(WiFi.status() != WL_CONNECTED)
  {
    //progress sedang mencari WiFi
    delay(500);
    Serial.print(".");
  }

  Serial.println("Wifi Connected");
  Serial.println("IP Address : ");
  Serial.println(WiFi.localIP());

  pinMode (LED_PIN, OUTPUT);
  pinMode (BTN_PIN, OUTPUT);
  
}  

void loop() {
  //baca status pin button kemudian uji
  if(digitalRead(BTN_PIN)==1)
  {

    digitalWrite (LED_PIN, HIGH);
    while(digitalRead(BTN_PIN)==1) ;
    //ubah mode absensi
    String getData, Link ;
    HTTPClient http;
    //get data
    Link = "http://192.168.43.62:8000/absensi/ubahmode.php";
    http.begin(Link);
    
    int httpCode = http.GET();
    String payload = http.getString();

    Serial.println(payload);
    http.end();
  }
    //matikan lampu led
    digitalWrite(LED_PIN, LOW);
  }
