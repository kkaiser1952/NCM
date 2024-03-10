Simply include the file adif_parser.php and create a new ADIF_Parser.

include 'adif_parser.php';

$p = new ADIF_Parser;

Now you need to give it some data. You can use the class member feed($string) to give it a string of text like this

$p->feed("ADIF File as String");
Or you can give it a filename with load_from_file($fname)

$p->load_from_file($fname);
Then it must be initialized with the initialize function and each record can be extracted using get_record(). get_record() returns an array with the field as the key. You can view the possible fields here. If the array is empty that means that there are no more records to process. Here is some example code to extract the callsigns from a text file called test.adi.

<?php
include 'adif_parser.php';

$p = new ADIF_Parser;
$p->load_from_file("test.adi");
$p->initialize();

while($record = $p->get_record())
{
	if(count($record) == 0)
	{
		break;
	};
	echo $record["call"]."<br>";
};
?>