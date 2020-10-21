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
* 01_01_配布書類一覧.pdf
* 03_04_入札説明書.pdf
* 05_26_仕様書.pdf
* 27_28_入札心得書.pdf
* 29_29_入札参加申込書.pdf
* 31_31_誓約書.pdf
* 33_37_委任状.pdf
* 39_43_入札書.pdf
* 45_55_業務委託契約書.pdf
* 57_57_同意書.pdf
* 59_59_機能等証明書.pdf
* 61_65_機能証明書明細書.pdf
* 66_66_守秘義務誓約書.pdf

Reference: https://umbalaconmeogia.wordpress.com/2020/09/24/pdftk-tool-xu-ly-file-pdf/