#define BAUD 9600
#include <Servo.h>

Servo myservo_1; 

int start_pos_x = 90;
int pos_x = 0;
int val = 0x00;
int new_pos_x = start_pos_x;
bool is_print = false;

//--------------------------------------------------------------- 5  R I G H T
void move_5_right()
{
  if(is_print)
  {
    Serial.print("move_5_right  pos_x = ");
    Serial.print(pos_x);
    Serial.print("   new_pos_x = ");
  }
  new_pos_x = pos_x + 5;
  if (new_pos_x > 180)
    new_pos_x = 180;
  for (pos_x; pos_x < new_pos_x; pos_x += 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
  if(is_print)
  {
    Serial.print(new_pos_x);
    Serial.print("  now pos_x = ");
    Serial.println(pos_x);
  }
}
//--------------------------------------------------------------- 5  L E F T
void move_5_left()
{
  if(is_print)
  {
    Serial.print("move_5_left  pos_x = ");
    Serial.print(pos_x);
    Serial.print("   new_pos_x = ");
  }
  if (pos_x < 5)
    new_pos_x = 5;
  else
    new_pos_x = pos_x - 5;
  for (pos_x; pos_x > new_pos_x; pos_x -= 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
  if(is_print)
  {
    Serial.print(new_pos_x);
    Serial.print("  now pos_x = ");
    Serial.println(pos_x);
  }
}
//--------------------------------------------------------------- 20  R I G H T
void move_20_right()
{
  if(is_print)
  {
    Serial.print("move_5_right  pos_x = ");
    Serial.print(pos_x);
    Serial.print("   new_pos_x = ");
  }
  new_pos_x = pos_x + 20;
  if (new_pos_x > 180)
    new_pos_x = 180;
  for (pos_x; pos_x < new_pos_x; pos_x += 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
  if(is_print)
  {
    Serial.print(new_pos_x);
    Serial.print("  now pos_x = ");
    Serial.println(pos_x);
  }
}
//--------------------------------------------------------------- 20  L E F T
void move_20_left()
{
  if(is_print)
  {
    Serial.print("move_5_left  pos_x = ");
    Serial.print(pos_x);
    Serial.print("   new_pos_x = ");
  }
  if (pos_x < 20)
    new_pos_x = 20;
  else
    new_pos_x = pos_x - 20;
  for (pos_x; pos_x > new_pos_x; pos_x -= 1) 
  {
    myservo_1.write(pos_x);
    delay(50);
  }
  if(is_print)
  {
    Serial.print(new_pos_x);
    Serial.print("  now pos_x = ");
    Serial.println(pos_x);
  }
}
//--------------------------------------------------------------- S E T U P
void setup() 
{
  myservo_1.attach(10);
  Serial.begin(BAUD);
  for (pos_x; pos_x < new_pos_x; pos_x += 1) 
  {
    myservo_1.write(pos_x);
    delay(100);
  }
  for (pos_x; pos_x > start_pos_x; pos_x -= 1) 
  {
    myservo_1.write(pos_x);
    delay(100);
  }
}
//--------------------------------------------------------------- L O O P
void loop() 
{
  while(Serial.available() == 0)
      delay(100);
  char input;
  if(Serial.available() > 0)
  {
    input = Serial.read();;
    
    switch (input) 
    {
    case '1':
      move_5_left();
      break;
    case '2':
      move_5_right();
      break;
    case '3':
      move_20_left();
      break;
    case '4':
      move_20_right();
      break;
    default:
      Serial.print(input-48);
    }
  }
}
