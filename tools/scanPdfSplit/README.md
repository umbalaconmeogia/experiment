# Scan document to pdf, then split into files according to title

Using a scanner that can only one side of papers (so for scan all pages, we should scan twice to get two files). Then split scanned big file into small pdf according to information specified in CSV file.

This tool need PHP and [PDFtk command line](https://www.pdflabs.com/docs/pdftk-cli-examples/) to be installed.

Steps

1. Scan data in two pdf files (named `file1.pdf` and `file2.pdf`).
2. Combine two files into one `combine.pdf`
3. Split `combine.pdf` into sub pdf files depends on the information in `split.csv`
  * `split.csv` contains 3 columns: `title`, `from page`, `to page` (`to page` may be omitted if sub pdf files has only one page).
  * Sub file will have name of type `from page`_`to page`_`title`.pdf

For example, run split.php with sample `split.csv` will generate files.
* 01_01_DocumentList.pdf
* 03_04_Overview.pdf
* 05_26_Specification.pdf
* 27_28_Direction.pdf
* 29_29_Application.pdf
* 31_31_WrittenOath.pdf
* 33_37_LetterOfCommission.pdf
* 39_43_Bid.pdf
* 45_55_Contract.pdf
* 57_57_Agreement.pdf
* 59_59_FunctionCertificate.pdf
* 61_65_FunctionCertificateDetail.pdf
* 66_66_NDA.pdf

Reference: https://umbalaconmeogia.wordpress.com/2020/09/24/pdftk-tool-xu-ly-file-pdf/