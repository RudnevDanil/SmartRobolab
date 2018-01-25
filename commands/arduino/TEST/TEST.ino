//Default baud speed for communication
#define BAUD 9600

int pos_x = 180;

void setup()
{
  Serial.begin(BAUD);
}

void loop()
{//отправляем позицию и нам говорят какую занять, занимаем
  String input;
  Serial.println(pos_x);
  delay(1000);
  //If any input is detected in arduino
  if(Serial.available() > 0)
  {
    //read the whole string until '\n' delimiter is read
    input = Serial.readStringUntil('\n');
    pos_x = input[0]+48;
    pos_x = (pos_x)*10 + input[1]+48;
    pos_x = (pos_x)*10 + input[2]+48;
    //if(pos_x > 180)
      //pos_x = 180;
    
  }
}
