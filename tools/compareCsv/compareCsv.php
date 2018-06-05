<?php
/**
 * Program to compare two CSV files (separated by comma).
 * Each CSV file has two columns, that are id and correspondance value.
 * This program will compare the value column based on the id.
 * Syntax:
 *   php compareCsv.php <file1.csv> <file2.csv>
 */
if (count($argv) !== 3) {
	echo "Syntax:\n";
	echo "  php compare.csv.php <file1.csv> <file2.csv>\n";
}

$file1 = $argv[1];
$file2 = $argv[2];
$compare = new CompareCsv();
$compare->compare($file1, $file2);

class ReadFile
{
	private $handle;
	private $eof;
	
	/**
	 * @param string $file CSV file name.
	 */
	public function __construct($file)
	{
		$this->handle = fopen($file, 'r');
		$this->eof = FALSE;
	}
	
	/**
	 * Read a row from CSV file.
	 * @return mixed Array of csv data, or FALSE if EOF.
	 */
	public function readRow()
	{
		$result = FALSE;
		if (!$this->eof) {
			$result = fgetcsv($this->handle);
			if ($result === FALSE) {
				$this->eof = TRUE;
			}
		}
		return $result;
	}
	
	public function isEof()
	{
		return $this->eof;
	}
	
	public function close()
	{
		fclose($this->handle);
	}
}

class CompareCsv
{
	public static $debug = TRUE;
	
	private $keyValues;

	/**
	 * @param string[2] key and value. May be FALSE if there is no data.
	 * @param $index
	 */
	private function addValue($fileRow, $index)
	{
		if ($fileRow) {
			if (count($fileRow) != 2) {
				echo "Invalid data in file $index\n";
				print_r($fileRow);
				die;
			}
			$key = $fileRow[0];
			$value = $fileRow[1];
			if (!isset($this->keyValues[$key])) {
				$this->keyValues[$key] = [FALSE, FALSE];
			}
			$this->keyValues[$key][$index] = $value;
			if (self::$debug) {
				echo "Set $key,$value at $index\n";
				print_r($this->keyValues);
			}
			// Clear $keyValues if two rooms are set.
			if ($this->keyValues[$key][0] !== FALSE && $this->keyValues[$key][1] !== FALSE) {
				unset($this->keyValues[$key]);
				if (self::$debug) {
					echo "Clear keyValue of key $key\n";
				}
			}
		}
	}
	
	public function compare($file1, $file2)
	{
		$this->keyValues = [];
		$file1 = new ReadFile($file1);
		$file2 = new ReadFile($file2);
		
		do {
			$this->addValue($file1->readRow(), 0);
			$this->addValue($file2->readRow(), 1);
		} while (!($file1->isEof() && $file2->isEof()));
		
		$file1->close();
		$file2->close();
		if (self::$debug) {
			echo "End\n";
			print_r($this->keyValues);
		}
	}
}