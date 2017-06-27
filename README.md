# php_tuple

This project will tuple coloums, (Network, Product, Month), of a uploaded Loans file by month, network and loa type.
Visit any of the links below and upload the file received from {Company X} in a .csv format.

[php_tuple POC](https://phptuple.herokuapp.com/web/upload_loan_file.php)   OR  
[php_tuple Final](https://phptuple.herokuapp.com/web_2/)

When in Debug mode the following will be displayed:
- File object
- Tuple Class Object
- JSON representation on the Tuple Class Object

The file hsould contain the folowing header:

	MSISDN,Network,Date,Product,Amount
Get the saple file [Here](https://phptuple.herokuapp.com/web_2/Loans.csv)

Once the file has been processed the Output file will be generated and save.
The file data will also be displayed in a textarea after file submittion! 
