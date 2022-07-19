#include <ESP8266WiFi.h>
#include <SPI.h>
#include <MFRC522.h>

#define RST_PIN D1
#define SDA_PIN D2

MFRC522 mfrc522(SDA_PIN, RST_PIN);
MFRC522::MIFARE_Key key;

// Setup variables:
    int serNum0;
    int serNum1;
    int serNum2;
    int serNum3;
    int serNum4;


const char* ssid     = "-=ME=-";
const char* password = "";

const char* host = "192.168.40.111";

WiFiClient client;
const int httpPort = 80;
String url;

unsigned long timeout;

const int id_device = 22;
  
void setup() {
  Serial.begin(9600);
  delay(10);
  

  SPI.begin(); 
  mfrc522.PCD_Init();
  
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}


void loop() {
  if(!mfrc522.PICC_IsNewCardPresent()){
    return;
  }

  if(!mfrc522.PICC_ReadCardSerial()){
    return;
  }

  Serial.print("UID tag :");
  String content = "";
  byte letter;

  for(byte i = 0; i < mfrc522.uid.size; i++){
    Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
    Serial.print(mfrc522.uid.uidByte[i], HEX);
    content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
    content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
Serial.print("connecting to ");
                Serial.println(host);
              
                if (!client.connect(host, httpPort)) {
                  Serial.println("connection failed");
                  //return;
                }
              
              // We now create a URI for the request
                url = "/crud/control/index.php?mode=save&iuid=";
                url += id_device;
                url += "&rfid=";
                url += content;
                
                Serial.print("Requesting URL: ");
                Serial.println(url);
              
              // This will send the request to the server
                client.print(String("GET ") + url + " HTTP/1.1\r\n" +
                             "Host: " + host + "\r\n" + 
                             "Connection: close\r\n\r\n");
                timeout = millis();
                while (client.available() == 0) {
                  if (millis() - timeout > 5000) {
                    Serial.println(">>> Client Timeout !");
                    client.stop();
                    return;
                  }
                }
              
              // Read all the lines of the reply from server and print them to Serial
                while(client.available()){
                  String line = client.readStringUntil('\r');
                  Serial.print(line);
                }
              
                Serial.println();
                Serial.println("closing connection");
                Serial.println();

} 
