//cd /D D:\Rudnev_Danil\my_rele_switch\work_point
#include <windows.h>
#include <stdio.h>
int main()
{
	unsigned char bytes_to_send[1];	
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_1.exe");
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_2.exe");
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_3.exe");
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_4.exe");
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_5.exe");
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_6.exe");
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_7.exe");
	system("C:\\OSPanel\\domains\\smartrobolab\\commands\\switch_8.exe");
	printf("\nbytes_to_send[0]=%d\n",bytes_to_send[0]);

    fprintf(stderr, "OK\n");
    return 0;
}