// gcc -o when_connect_arduino when_connect_arduino.cpp
#include <windows.h>
#include <stdio.h>

int main()
{
	unsigned char bytes_to_send[3];

	bytes_to_send[0]=48;
	bytes_to_send[1]=57;
	bytes_to_send[2]=48;
	
	FILE *status_file_w;
	status_file_w = fopen("arduino_status_file","w");
	if(status_file_w == NULL)
	{
		printf("---I can't open status_file!");
		return 0;
	}
	fwrite(bytes_to_send, 1,3 , status_file_w);
	fclose(status_file_w);
    return 0;
}