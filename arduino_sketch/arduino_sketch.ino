#define BAUD 9600
#include <Servo.h>
#include <SoftwareSerial.h>

Servo myservo_1; 

int start_pos_x = 90;
int pos_x = start_pos_x;
int new_pos_x = start_pos_x;
bool is_print = false;
int relay_state = 0;

//--------------------------------------------------------------- 5  R I G H T
void move_5_right()
{
  new_pos_x = pos_x + 5;
  if (new_pos_x > 180)
    new_pos_x = 180;
  for (pos_x; pos_x < new_pos_x; pos_x += 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
}
//--------------------------------------------------------------- 5  L E F T
void move_5_left()
{
  if (pos_x < 5)
    new_pos_x = 5;
  else
    new_pos_x = pos_x - 5;
  for (pos_x; pos_x > new_pos_x; pos_x -= 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
}
//--------------------------------------------------------------- 20  R I G H T
void move_20_right()
{
  new_pos_x = pos_x + 20;
  if (new_pos_x > 180)
    new_pos_x = 180;
  for (pos_x; pos_x < new_pos_x; pos_x += 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
}
//--------------------------------------------------------------- 20  L E F T
void move_20_left()
{
  if (pos_x < 20)
    new_pos_x = 20;
  else
    new_pos_x = pos_x - 20;
  for (pos_x; pos_x > new_pos_x; pos_x -= 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
}
//--------------------------------------------------------------- S W I T C H E R
void switcher(int which_switch)
{
  if ((which_switch!= 9) && (which_switch != 10))
  {
    int byf = relay_state;
    int p = (which_switch == 1)?1:2;
    byf = byf >> (which_switch - 1);
  
    for(int i = 1; i < which_switch - 1; i++)
      p *= 2;
      
    if(byf % 2 == 0)
      relay_state += p;
    else
      relay_state -= p;
  }
  else if(which_switch ==9)
  {
    relay_state = 0;
  }
  else// == 10
  {
    relay_state = 255;
  }
  
  Serial.write(relay_state);
}
//--------------------------------------------------------------- S E T U P
void setup() 
{
  myservo_1.attach(9);  
  myservo_1.write(start_pos_x);
  
  Serial.begin(BAUD);
  pinMode(7, OUTPUT);
  digitalWrite(7,LOW); 
  delay(1000);
  digitalWrite(7,HIGH);
  
  Serial.write(0x50);
  delay(100);
  Serial.write(0x51);
  delay(100);
  Serial.write(0);

  pinMode(13, OUTPUT); 
}
//--------------------------------------------------------------- L O O P
void loop() 
{  
  while(Serial.available() == 0)
      delay(100);
  char input;
  if(Serial.available() > 0)
  {
    input = Serial.read();
    switch (input)
    {
    case 'w':
      move_5_left();      
      break;
    case 'e':
      move_5_right();
      break;
    case 'q':
      move_20_left();
      break;
    case 'r':
      move_20_right();
      break;
    case '1':
      switcher(1);
      break;
    case '2':
      switcher(2);
      break;
    case '3':
      switcher(3);
      break;
    case '4':
      switcher(4);
      break;
    case '5':
      switcher(5);
      break;
    case '6':
      switcher(6);
      break;
    case '7':
      switcher(7);
      break;
    case '8':
      switcher(8);
      break;
    case 'f':
      switcher(9);
      break;
    case 'n':
      switcher(10);
      break;
    case 's':
      relay_state = 255 - relay_state;
      Serial.write(relay_state);
      break;
    default:
      digitalWrite(13,HIGH);
    }
  }
  delay(1000);
  digitalWrite(13,LOW);
  delay(100);
}

