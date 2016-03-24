

// Example from the Internet
// https://github.com/lucadentella/enc28j60_tutorial/blob/master/_5_BasicServer/_5_BasicServer.ino
#include <EtherCard.h>


// ethernet mac address - must be unique on your network
static byte mymac[] = { 0xB8,0x2A,0x72,0xA8,0x60,0x22 };
// ethernet interface ip address
static byte myip[] = { 192,168,1,200 };
// gateway ip address
static byte gwip[] = { 192,168,1,1 };
//const char website[] PROGMEM = "192.168.1.104";

byte Ethernet::buffer[500]; // tcp/ip send and receive buffer

const int bottun = 3;

// Some stuff for responding to the request
char* on = "ON";
char* off = "OFF";
char* statusLabel;
char* buttonLabel;

// Small web page to return so the request is completed
const char page[] PROGMEM =
"HTTP/1.0 503 Service Unavailable\r\n"
"Content-Type: text/html\r\n"
"Retry-After: 600\r\n"
"\r\n"
"<html>"
  "<head><title>"
    "Arduino 192.168.1.5"
  "</title></head>"
  "<body>"
    "<h3>Arduino 192.168.1.5</h3>"
  "</body>"
"</html>"
;


void setup(){
  Serial.begin(9600);
  pinMode(bottun,OUTPUT);
  digitalWrite(bottun,LOW);
  

// Scary complex intializing of the EtherCard - I don't understand this stuff (yet0  
  ether.begin(sizeof Ethernet::buffer, mymac);
// Set IP using Static
  ether.staticSetup(myip, gwip);
}

void loop(){
  word len = ether.packetReceive();
  word pos = ether.packetLoop(len);
// IF PUMP2=ON turn it ONledPin3
  if (0) //(len!=0)
  {
    Serial.print("Got packet\n");
    Serial.print((const char*) Ethernet::buffer);
     Serial.println("---");
  }
  if(strstr((char *)Ethernet::buffer + pos, "GET /?PUMP2=ON") != 0) { 
    digitalWrite(bottun,HIGH);  
      Serial.print('P');
      delay(500);
    }

// IF PUMP2=OFF turn it OFF  
    if(strstr((char *)Ethernet::buffer + pos, "GET /?PUMP2=OFF") != 0) {
      //strstr((char *)Ethernet::buffer + pos, "POST /?raed=1")
      digitalWrite(bottun,LOW);
      Serial.print('N');
      delay(500);
    }

//Return a page so the request is completed.

    memcpy_P(ether.tcpOffset(), page, sizeof page);
    ether.httpServerReply(sizeof page - 1);
    

    
  if(Serial.available())
  {
    char getData = Serial.read();
    if(getData == 'B')
    {
      digitalWrite(bottun,HIGH);
      delay(500);
    }
    if(getData == 'O')
    {
      digitalWrite(bottun,LOW);
      delay(500);
    }
  getData = ' ';
  }
  
}
