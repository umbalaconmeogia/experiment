# Scan document to pdf, then split into files according to title

Using a scanner that can only one side of papers (so for scan all pages, we should scan twice to get two files). Then split scanned big file into small pdf according to information specified in CSV file.

This tool need PHP and [PDFtk command line](https://www.pdflabs.com/docs/pdftk-cli-examples/) to be installed.

Steps

1. Scan data in two pdf files (named `file1.pdf` and `file2.pdf`).
2. Combine two files into one `combine.pdf`
3. Split `combine.pdf` into sub pdf files depends on the information in `split.csv`
  * `split.csv` contains 3 columns: `title`, `from page`, `to page` (`to page` may be omitted if sub pdf files has only one page).
  * Sub file will have name of type `from page`_`to page`_`title`.pdf

Reference: https://umbalaconmeogia.wordpress.com/2020/09/24/pdftk-tool-xu-ly-file-pdf/